@extends('layouts.app')

@section('template_title')
Transactions
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
                        <form method="GET" action="{{ route('transactions.index') }}" class="mb-4">
                            <div class="row">
                                <!-- Filter Tanggal Awal -->
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Tanggal Awal</label>
                                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $startDate) }}" class="form-control">
                                </div>

                                <!-- Filter Tanggal Akhir -->
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $endDate) }}" class="form-control">
                                </div>

                                <!-- Filter Metode Pembayaran -->
                                <div class="col-md-2">
                                    <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                    <select name="payment_method" id="payment_method" class="form-select">
                                        <option value="">Semua</option>
                                        @foreach($paymentMethods as $id => $name)
                                        <option value="{{ $id }}" {{ $paymentMethodId == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter Kategori -->
                                <div class="col-md-2">
                                    <label for="category" class="form-label">Kategori</label>
                                    <select name="category" id="category" class="form-select">
                                        <option value="">Semua</option>
                                        @foreach($categories as $id => $name)
                                        <option value="{{ $id }}" {{ $categoryId == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter Tipe -->
                                <div class="col-md-2">
                                    <label for="type" class="form-label">Tipe</label>
                                    <select name="type" id="type" class="form-select">
                                        <option value="">Semua</option>
                                        <option value="income" {{ $type == 'income' ? 'selected' : '' }}>Income</option>
                                        <option value="expense" {{ $type == 'expense' ? 'selected' : '' }}>Expense</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr class="{{ $transaction->type === 'expense' ? 'table-danger' : '' }}">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $transaction->category_name }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->method_name }}</td>
                                    <td>{{ number_format($transaction->amount, 0, '', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}</td>
                                    <td>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-success btn-sm">Edit</a>
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">
                                                <i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
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