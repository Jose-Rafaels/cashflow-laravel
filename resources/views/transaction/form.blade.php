<div class="row padding-1 p-1">
    <div class="col-md-12">
        <div class="form-group mb-2">
            <label for="payment_method_id" class="form-label">{{ __('Payment Method') }}</label>
            <select name="payment_method_id" id="payment_method_id" class="form-select @error('payment_method_id') is-invalid @enderror">
                <option value="" disabled selected>-- Select Payment Method --</option>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->id }}" {{ old('payment_method_id', $transaction?->payment_method_id) == $method->id ? 'selected' : '' }}>
                        {{ $method->method_name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('payment_method_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        
        <div class="form-group mb-2">
            <label for="category_id" class="form-label">{{ __('Category') }}</label>
            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                <option value="" disabled selected>-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $transaction?->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('category_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="amount" class="form-label">{{ __('Amount') }}</label>
            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $transaction?->amount) }}" id="amount" placeholder="Amount">
            {!! $errors->first('amount', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="description" class="form-label">{{ __('Description') }}</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $transaction?->description) }}" id="description" placeholder="Description">
            {!! $errors->first('description', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="transaction_date" class="form-label">{{ __('Transaction Date') }}</label>
            <input type="date" name="transaction_date" class="form-control @error('transaction_date') is-invalid @enderror" value="{{ old('transaction_date', $transaction?->transaction_date) }}" id="transaction_date" placeholder="Transaction Date">
            {!! $errors->first('transaction_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>