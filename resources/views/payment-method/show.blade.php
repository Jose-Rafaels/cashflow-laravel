@extends('layouts.app')

@section('template_title')
{{ $paymentMethod->name ?? __('Show') . " " . __('Payment Method') }}
@endsection

@section('content')
<section class="content container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="float-left">
                        <span class="card-title">{{ __('Show') }} Payment Method</span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('payment-methods.index') }}"> {{ __('Back')
                            }}</a>
                    </div>
                </div>

                <div class="card-body bg-white">

                    <div class="form-group mb-2 mb20">
                        <strong>Method Name:</strong>
                        {{ $paymentMethod->method_name }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection