<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="user_id" class="form-label">{{ __('User Id') }}</label>
            <input type="text" name="user_id" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id', $transactionTotal?->user_id) }}" id="user_id" placeholder="User Id">
            {!! $errors->first('user_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="total_balance" class="form-label">{{ __('Total Balance') }}</label>
            <input type="text" name="total_balance" class="form-control @error('total_balance') is-invalid @enderror" value="{{ old('total_balance', $transactionTotal?->total_balance) }}" id="total_balance" placeholder="Total Balance">
            {!! $errors->first('total_balance', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="last_transaction_id" class="form-label">{{ __('Last Transaction Id') }}</label>
            <input type="text" name="last_transaction_id" class="form-control @error('last_transaction_id') is-invalid @enderror" value="{{ old('last_transaction_id', $transactionTotal?->last_transaction_id) }}" id="last_transaction_id" placeholder="Last Transaction Id">
            {!! $errors->first('last_transaction_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>