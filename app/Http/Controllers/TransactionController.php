<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionTotal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // $transactions = Transaction::paginate();
        $transactions = Transaction::where('user_id',  Auth::id())->with('paymentMethod')->paginate();
        return view('transaction.index', compact('transactions'))
            ->with('i', ($request->input('page', 1) - 1) * $transactions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // $transaction = new Transaction();
        $paymentMethods = PaymentMethod::all();

        return view('transaction.create', compact('paymentMethods'));
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
            ]);
            $last_totals = TransactionTotal::where('user_id', Auth::id())->value('total_balance');
            $update_amout = $last_totals + $amount;

            TransactionTotal::where('user_id', Auth::id())->update(['last_transaction_id' => $last_transaction->id, 'total_balance' => $update_amout]);
            DB::commit();
            return Redirect::route('transactions.index')
                ->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Jika terjadi error, kembalikan dengan pesan gagal
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
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

        return view('transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $transaction->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'payment_method_id' => $request->payment_method_id,
        ]);

        return Redirect::route('transactions.index')
            ->with('success', 'Transaction updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Transaction::find($id)->delete();

        return Redirect::route('transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }
    public function getFinancialData($year, $month)
    {
        // Query untuk mendapatkan data income dan expense per hari dalam bulan dan tahun yang ditentukan
        $transactions = DB::table('transactions')
            ->selectRaw('DAY(transaction_date) as transaction_date, 
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) AS total_income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) AS total_expense')
            ->whereRaw('MONTH(transaction_date) = ?', [$month])
            ->whereRaw('YEAR(transaction_date) = ?', [$year])
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->get();

        // Memisahkan data ke dalam array untuk dikembalikan sebagai JSON
        $labels = $transactions->pluck('transaction_date')->toArray();
        $incomeData = $transactions->pluck('total_income')->toArray();
        $expenseData = $transactions->pluck('total_expense')->toArray();

        // Mengembalikan data dalam format JSON
        return response()->json([
            'labels' => $labels,
            'incomeData' => $incomeData,
            'expenseData' => $expenseData
        ]);
    }
}
