<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionTotal;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // $transactions = Transaction::paginate();
        $transactions = Transaction::where('user_id', Auth::id())->with('paymentMethod')->with('category')->paginate();
        return view('transaction.index', compact('transactions'))->with('i', ($request->input('page', 1) - 1) * $transactions->perPage());
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'type' => 'required|in:income,expense',
            'category_id' => 'nullable|exists:categories,id',
            'transaction_date' => 'required|date',
        ]);

        $amount = $request->type === 'expense' ? -$request->amount : $request->amount;

        try {
            DB::beginTransaction();

            $last_transaction = Transaction::create([
                'user_id' => Auth::id(),
                'payment_method_id' => $request->payment_method_id,
                'amount' => $request->amount,
                'description' => $request->description,
                'type' => $request->type,
                'transaction_date' => $request->transaction_date,
                'category_id' => $request->category_id, // Menyimpan kategori
            ]);
            $last_totals = TransactionTotal::where('user_id', Auth::id())->value('total_balance');
            $update_amout = $last_totals + $amount;

            TransactionTotal::where('user_id', Auth::id())->update(['last_transaction_id' => $last_transaction->id, 'total_balance' => $update_amout]);
            DB::commit();
            return Redirect::route('transactions.index')->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Jika terjadi error, kembalikan dengan pesan gagal
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $transaction = Transaction::find($id);

        return view('transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $transaction = Transaction::find($id);
        $paymentMethods = PaymentMethod::select('id', 'method_name')->get();
        $categories = Category::select('id', 'name')->get();
        return view('transaction.edit', compact('transaction', 'categories', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        // $request->validate([
        //     'amount' => 'required|numeric',
        //     'description' => 'nullable|string',
        //     'payment_method_id' => 'required|exists:payment_methods,id',
        //     'category_id' => 'required|exists:categories,id',

        // ]);

        $transaction->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'payment_method_id' => $request->payment_method_id,
            'category_id' => $request->category_id,
        ]);

        return Redirect::route('transactions.index')->with('success', 'Transaction updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Transaction::find($id)->delete();

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
        $cashBalance = $totalIncome + $totalExpense; // Pengeluaran negatif, sehingga dijumlahkan

        // Net Cashflow (positif/negatif)
        $netCashflow = $totalIncome + $totalExpense; // Karena pengeluaran sudah negatif
        // Query untuk mendapatkan data income dan expense per hari dalam bulan dan tahun yang ditentukan
        $transactions = DB::table('transactions')
            ->selectRaw(
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

        $paymentMethodData = DB::table('transactions')
            ->join('payment_methods', 'transactions.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw(
                'payment_methods.method_name,
                SUM(CASE WHEN transactions.type = "income" THEN transactions.amount ELSE 0 END) AS total_income,
                SUM(CASE WHEN transactions.type = "expense" THEN transactions.amount ELSE 0 END) AS total_expense',
            )
            ->where('transactions.user_id', Auth::id())
            ->whereBetween('transactions.transaction_date', [$startOfMonth, $endOfMonth])
            ->groupBy('payment_methods.method_name')
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
            'total_income' => $totalIncome,
            'total_expense' => abs($totalExpense), // Buat pengeluaran menjadi positif untuk tampilan
            'cash_balance' => $cashBalance,
            'net_cashflow' => $netCashflow > 0 ? 'positive' : 'negative',
            'year' => $year,
            'month' => $month,
            'payment_method_labels' => $paymentMethodLabels,
            'payment_method_income' => $paymentMethodIncome,
            'payment_method_expense' => $paymentMethodExpense,
        ]);
    }
}
