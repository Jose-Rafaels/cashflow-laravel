@extends('layouts.app')

@section('template_title')
{{ __('Create') }} Transaction
@endsection

@section('content')
<section class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Tambah Transaksi Baru</span>
                </div>
                <div class="card-body bg-white">
                    <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('transaction.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection