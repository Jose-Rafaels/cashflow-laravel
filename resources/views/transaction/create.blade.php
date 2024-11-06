@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Transaction
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Tambah Transaksi Baru</span>
                    </div>
                    <div class="m-4">
                        <form action="{{ route('transactions.store') }}" method="POST" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="type" class="form-label">Jenis Transaksi</label>
                                <select name="type" id="type" class="form-select" required>
                                    <option value="">Pilih Transaksi</option>
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah</label>
                                <input type="number" name="amount" id="amount" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="transaction_date" class="form-label">Tanggal Transaksi</label>
                                <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="payment_method_id" class="form-label">Metode Pembayaran</label>
                                <select name="payment_method_id" id="payment_method_id" class="form-select" required>
                                    <option value="" selected>Pilih Metode</option>
                                    @foreach ($paymentMethods as $method)
                                        <option value="{{ $method->id }}">{{ $method->method_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="" selected>Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
