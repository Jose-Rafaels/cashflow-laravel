@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Transaction
@endsection

@section('content')
    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Transaction</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('transactions.update', $transaction->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('transaction.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
