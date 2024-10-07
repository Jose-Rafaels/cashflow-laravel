<?php

namespace App\Http\Controllers;

use App\Models\TransactionTotal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionTotalRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TransactionTotalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $transactionTotals = TransactionTotal::paginate();

        return view('transaction-total.index', compact('transactionTotals'))
            ->with('i', ($request->input('page', 1) - 1) * $transactionTotals->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $transactionTotal = new TransactionTotal();

        return view('transaction-total.create', compact('transactionTotal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionTotalRequest $request): RedirectResponse
    {
        TransactionTotal::create($request->validated());

        return Redirect::route('transaction-totals.index')
            ->with('success', 'TransactionTotal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $transactionTotal = TransactionTotal::find($id);

        return view('transaction-total.show', compact('transactionTotal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $transactionTotal = TransactionTotal::find($id);

        return view('transaction-total.edit', compact('transactionTotal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionTotalRequest $request, TransactionTotal $transactionTotal): RedirectResponse
    {
        $transactionTotal->update($request->validated());

        return Redirect::route('transaction-totals.index')
            ->with('success', 'TransactionTotal updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        TransactionTotal::find($id)->delete();

        return Redirect::route('transaction-totals.index')
            ->with('success', 'TransactionTotal deleted successfully');
    }
}
