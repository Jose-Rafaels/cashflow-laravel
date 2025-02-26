<div class="form-group mb-3">
    <label for="type" class="form-label">{{ __('Jenis Transaksi') }}</label>
    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
        <option value="" disabled {{ old('type', $transaction?->type ?? '') ? '' : 'selected' }}>-- Pilih Transaksi --</option>
        <option value="income" {{ old('type', $transaction?->type ?? '') == "income" ? 'selected' : '' }}>Pemasukan</option>
        <option value="expense" {{ old('type', $transaction?->type ?? '') == "expense" ? 'selected' : '' }}>Pengeluaran</option>
    </select>

    {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<div class="form-group mb-3">
    <label for="payment_method_id" class="form-label">{{ __('Metode Pembayaran') }}</label>
    <select name="payment_method_id" id="payment_method_id" class="form-select @error('payment_method_id') is-invalid @enderror" required>
        <option value="" disabled {{ old('payment_method_id', $transaction?->payment_method_id ?? '') ? '' : 'selected' }}>-- Pilih Metode --</option>
        @foreach($paymentMethods as $method)
        <option value="{{ $method->id }}" {{ old('payment_method_id', $transaction?->payment_method_id ?? '') == $method->id ? 'selected' : '' }}>
            {{ $method->method_name }}
        </option>
        @endforeach
    </select>
    {!! $errors->first('payment_method_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<div class="form-group mb-3">
    <label for="category_id" class="form-label">{{ __('Kategori') }}</label>
    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
        <option value="" disabled {{ old('category_id', $transaction?->category_id ?? '') ? '' : 'selected' }}>-- Pilih Kategori --</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ old('category_id', $transaction?->category_id ?? '') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
        @endforeach
    </select>
    {!! $errors->first('category_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<div class="form-group mb-3">
    <label for="amount" class="form-label">{{ __('Jumlah') }}</label>
    <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
        value="{{ old('amount', $transaction?->amount ?? '') }}" id="amount" placeholder="Jumlah" required>
    {!! $errors->first('amount', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<div class="form-group mb-3">
    <label for="transaction_date" class="form-label">{{ __('Tanggal Transaksi') }}</label>
    <input type="date" name="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror"
        value="{{ old('transaction_date', $transaction?->transaction_date ?? '') }}" id="transaction_date" required>
    {!! $errors->first('transaction_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>

<div class="form-group mb-3">
    <label for="description" class="form-label">{{ __('Deskripsi') }}</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Deskripsi">{{ old('description', $transaction?->description ?? '') }}</textarea>
    {!! $errors->first('description', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>


<button type="submit" class="btn btn-primary">{{ $submitButtonText ?? __('Simpan') }}</button>