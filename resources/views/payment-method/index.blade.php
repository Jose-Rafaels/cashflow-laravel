@extends('layouts.app')

@section('template_title')
Payment Methods
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Payment Methods') }}
                        </span>

                        <div class="float-right">
                            <button onclick="openCreateModal('{{ route('payment-methods.store') }}')"
                                class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Create New') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Method Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($paymentMethods as $paymentMethod)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $paymentMethod->method_name }}</td>

                                    <td>


                                        <form action="{{ route('payment-methods.destroy', $paymentMethod->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
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
            {!! $paymentMethods->withQueryString()->links() !!}
        </div>
    </div>
    <!-- Modal for Create / Edit Payment Method -->
    <div class="modal fade" id="paymentMethodModal" tabindex="-1" role="dialog"
        aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentMethodModalLabel">Form Payment Method</h5>
                    <div class="ms-auto">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>

                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="paymentMethodForm" method="POST" action="">
                        @csrf
                        <input type="hidden" id="methodField" name="_method" value="">
                        <div class="form-group">
                            <label for="method_name">{{ __('Method Name') }}</label>
                            <input type="text" class="form-control" id="method_name" name="method_name"
                                placeholder="Method Name">
                            {!! $errors->first('method_name', '<div class="invalid-feedback" role="alert">
                                <strong>:message</strong>
                            </div>') !!}
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
            @if ($errors->any())
                $('#paymentMethodModal').modal('show');
                // Jika ada input sebelumnya, isi ulang inputnya
                $('#method_name').val('{{ old('method_name') }}');
            @endif
        });

        function openCreateModal(actionUrl) {
            // Set action URL for create
            $('#paymentMethodForm').attr('action', actionUrl);
            // Remove method field for create (POST is default)
            $('#methodField').val('');
            // Clear form input
            $('#method_name').val('');
            // Update modal title
            $('#paymentMethodModalLabel').text('Create Payment Method');
            // Show modal
            $('#paymentMethodModal').modal('show');
        }

        function closeModal() {
            $('#paymentMethodModal').modal('hide');
        }
</script>
@endsection