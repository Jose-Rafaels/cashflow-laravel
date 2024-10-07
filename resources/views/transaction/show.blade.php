@extends('layouts.app')

@section('template_title')
    {{ $transaction->name ?? __('Show') . " " . __('Transaction') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Transaction</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('transactions.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>User Id:</strong>
                                    {{ $transaction->user_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Payment Method Id:</strong>
                                    {{ $transaction->payment_method_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Amount:</strong>
                                    {{ $transaction->amount }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Description:</strong>
                                    {{ $transaction->description }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Transaction Date:</strong>
                                    {{ $transaction->transaction_date }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
