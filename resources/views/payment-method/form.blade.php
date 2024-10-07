<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="method_name" class="form-label">{{ __('Method Name') }}</label>
            <input type="text" name="method_name" class="form-control @error('method_name') is-invalid @enderror" value="{{ old('method_name', $paymentMethod?->method_name) }}" id="method_name" placeholder="Method Name">
            {!! $errors->first('method_name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>