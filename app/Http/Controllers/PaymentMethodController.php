<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentMethodRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $paymentMethods = PaymentMethod::paginate();

        return view('payment-method.index', compact('paymentMethods'))->with('i', ($request->input('page', 1) - 1) * $paymentMethods->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $paymentMethod = new PaymentMethod();

        return view('payment-method.create', compact('paymentMethod'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMethodRequest $request): RedirectResponse
    {
        PaymentMethod::create($request->validated());

        return Redirect::route('payment-methods.index')->with('success', 'PaymentMethod created successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $paymentMethod = PaymentMethod::find($id);

        // Cek apakah metode pembayaran digunakan dalam transaksi
        if ($paymentMethod->transactions()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete this payment method because it is used in transactions.');
        }

        // Hapus metode pembayaran jika tidak digunakan
        $paymentMethod->delete();

        return Redirect::route('payment-methods.index')->with('success', 'PaymentMethod deleted successfully');
    }
}
