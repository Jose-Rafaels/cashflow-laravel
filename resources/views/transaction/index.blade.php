@extends('layouts.app')

@section('template_title')
Transactions
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Daftar Transaksi') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm float-right"
                                data-placement="left">
                                {{ __('Tambah Transaksi') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="table-responsive">

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Deskripsi</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr class="{{ $transaction->type === 'expense' ? 'table-danger' : '' }}">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->paymentMethod->method_name }}</td>
                                    <td>{{ $transaction->category->name }}</td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->transaction_date }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection