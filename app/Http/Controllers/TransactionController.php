<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Mendapatkan input filter dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $paymentMethodId = $request->input('payment_method');
        $categoryId = $request->input('category');
        $type = $request->input('type');

        // Memulai query dengan filter user_id
        $query = Transaction::query()
            ->where('transactions.user_id', Auth::id())
            ->join('payment_methods', 'transactions.payment_method_id', '=', 'payment_methods.id')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select([
                'transactions.id',
                'transactions.description',
                'transactions.amount',
                'transactions.transaction_date',
                'transactions.type',
                'payment_methods.method_name',
                'categories.name as category_name',
            ]);

        // Menerapkan filter tanggal jika tersedia
        if ($startDate && $endDate) {
            $query->whereBetween('transactions.transaction_date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('transactions.transaction_date', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('transactions.transaction_date', '<=', $endDate);
        }

        // Menerapkan filter metode pembayaran jika tersedia
        if ($paymentMethodId) {
            $query->where('payment_methods.id', $paymentMethodId);
        }

        // Menerapkan filter kategori jika tersedia
        if ($categoryId) {
            $query->where('categories.id', $categoryId);
        }

        // Menerapkan filter tipe transaksi jika tersedia
        if ($type && in_array($type, ['income', 'expense'])) {
            $query->where('transactions.type', $type);
        }

        // Mengatur urutan hasil, misalnya berdasarkan tanggal transaksi terbaru
        $query->orderBy('transactions.transaction_date', 'desc');

        // Mengambil hasil dengan pagination
        $transactions = $query->paginate(20)->appends($request->except('page'));

        // Mendapatkan indeks untuk penomoran
        $i = ($request->input('page', 1) - 1) * $transactions->perPage();

        // Mengambil daftar metode pembayaran dan kategori untuk form filter
        $paymentMethods = Transaction::join('payment_methods', 'transactions.payment_method_id', '=', 'payment_methods.id')
            ->where('transactions.user_id', Auth::id())
            ->select('payment_methods.id', 'payment_methods.method_name')
            ->distinct()
            ->pluck('method_name', 'id');

        // Mendapatkan kategori yang pernah digunakan dalam transaksi
        $categories = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', Auth::id())
            ->select('categories.id', 'categories.name')
            ->distinct()
            ->pluck('name', 'id');

        return view('transaction.index', compact('transactions', 'i', 'paymentMethods', 'categories', 'startDate', 'endDate', 'paymentMethodId', 'categoryId', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // $transaction = new Transaction();
        $paymentMethods = PaymentMethod::all();
        $categories = Category::all();
        return view('transaction.create', compact('paymentMethods', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request): RedirectResponse
    {

        try {
            Transaction::create([
                'user_id' => Auth::id(),
                'payment_method_id' => $request->payment_method_id,
                'amount' => $request->amount,
                'description' => $request->description,
                'type' => $request->type,
                'transaction_date' => $request->transaction_date,
                'category_id' => $request->category_id, // Menyimpan kategori
            ]);

            return Redirect::route('transactions.index')->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {

            // Jika terjadi error, kembalikan dengan pesan gagal
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $transaction = Transaction::find($id);
        if (is_null($transaction) || $transaction->user_id != Auth::id()) {
            abort(404);
        }
        $paymentMethods = PaymentMethod::select('id', 'method_name')->get();
        $categories = Category::select('id', 'name')->get();
        return view('transaction.edit', compact('transaction', 'categories', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        if ($transaction->user_id != Auth::id()) {
            return Redirect::route('transactions.index')->with('error', "Transactions can't be updated");
        }
        $transaction->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'type' => $request->type,
            'payment_method_id' => $request->payment_method_id,
            'category_id' => $request->category_id,
        ]);

        return Redirect::route('transactions.index')->with('success', 'Transaction updated successfully');
    }

    public function destroy($id): RedirectResponse
    {

        $transaction = Transaction::find($id);
        if ($transaction->user_id != Auth::id()) {
            return Redirect::route('transactions.index')->with('error', "Transactions can't be deleted");
        }
        $transaction->delete();

        return Redirect::route('transactions.index')->with('success', 'Transaction deleted successfully');
    }
    public function getFinancialData($year, $month)
    {
        // Awal dan akhir dari periode (bulan/tahun) yang dipilih
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

        // Total Pemasukan (income)
        $totalIncome = Transaction::where('user_id', Auth::id())
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Total Pengeluaran (expense)
        $totalExpense = Transaction::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Saldo Kas
        $cashBalance = $totalIncome - $totalExpense; // Pengeluaran positif, sehingga dikurangkan
        // Query untuk mendapatkan data income dan expense per hari dalam bulan dan tahun yang ditentukan
        $transactions = Transaction::selectRaw(
            'DAY(transaction_date) as transaction_date,
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) AS total_income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) AS total_expense',
        )
            ->whereRaw('user_id = ?', Auth::id())
            ->whereRaw('MONTH(transaction_date) = ?', [$month])
            ->whereRaw('YEAR(transaction_date) = ?', [$year])
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->get();

        $paymentMethodData = Transaction::join('payment_methods', 'transactions.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw(
                'payment_methods.method_name,
                SUM(CASE WHEN transactions.type = "income" THEN transactions.amount ELSE 0 END) AS total_income,
                SUM(CASE WHEN transactions.type = "expense" THEN transactions.amount ELSE 0 END) AS total_expense'
            )
            ->where('transactions.user_id', Auth::id())
            ->whereBetween('transactions.transaction_date', [$startOfMonth, $endOfMonth])
            ->groupBy('payment_methods.method_name')
            ->havingRaw('total_income > 0 OR total_expense > 0') // Menyaring metode dengan nilai transaksi
            ->get();

        // Memisahkan data ke dalam array untuk dikembalikan sebagai JSON
        $labels = $transactions->pluck('transaction_date')->toArray();
        $incomeData = $transactions->pluck('total_income')->toArray();
        $expenseData = $transactions->pluck('total_expense')->toArray();

        // Pisahkan data metode pembayaran untuk pie chart
        $paymentMethodLabels = $paymentMethodData->pluck('method_name')->toArray();
        $paymentMethodIncome = $paymentMethodData->pluck('total_income')->toArray();
        $paymentMethodExpense = $paymentMethodData->pluck('total_expense')->toArray();
        // Mengembalikan data dalam format JSON
        return response()->json([
            'labels' => $labels,
            'incomeData' => $incomeData,
            'expenseData' => $expenseData,
            'total_income' => number_format($totalIncome, 0, '', '.'),
            'total_expense' =>  number_format(abs($totalExpense), 0, '', '.'), // Buat pengeluaran menjadi positif untuk tampilan
            'cash_balance' =>  number_format($cashBalance, 0, '', '.'),
            'net_cashflow' => $cashBalance > 0 ? 'Positive' : 'Negative',
            'year' => $year,
            'month' => $month,
            'payment_method_labels' => $paymentMethodLabels,
            'payment_method_income' => $paymentMethodIncome,
            'payment_method_expense' => $paymentMethodExpense,
        ]);
    }
}
