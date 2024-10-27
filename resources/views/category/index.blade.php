@extends('layouts.app')

@section('template_title')
Categories
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Categories') }}
                        </span>

                        <div class="float-right">
                            <button onclick="openCreateModal('{{ route('categories.store') }}')"
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
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i
                                                    class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $categories->withQueryString()->links() !!}
        </div>
    </div>
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Form Category</h5>
                    <div class="ms-auto">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="categoryForm" method="POST" action="">
                        @csrf
                        <input type="hidden" id="methodField" name="_method" value="">
                        <div class="form-group">
                            <label for="category_name">{{ __('Category Name') }}</label>
                            <input type="text" class="form-control" id="category_name" name="name"
                                placeholder="Category Name">
                            {!! $errors->first(
                            'category_name',
                            '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
                            ) !!}
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
                $('#categoryModal').modal('show');
                // Jika ada input sebelumnya, isi ulang inputnya
                $('#category_name').val('{{ old('category_name') }}');
            @endif
        });

        // function openEditModal(actionUrl, categoryName) {
        //     // Set action URL untuk edit
        //     $('#categoryForm').attr('action', actionUrl);
        //     // Set method ke PATCH untuk edit
        //     $('#methodField').val('PATCH');
        //     // Set nilai input form
        //     $('#category_name').val(categoryName);
        //     // Update judul modal
        //     $('#categoryModalLabel').text('Edit Category');
        //     // Tampilkan modal
        //     $('#categoryModal').modal('show');
        // }

        function openCreateModal(actionUrl) {
            // Set action URL untuk create
            $('#categoryForm').attr('action', actionUrl);
            // Hapus method field untuk create (POST adalah default)
            $('#methodField').val('');
            // Kosongkan input form
            $('#category_name').val('');
            // Update judul modal
            $('#categoryModalLabel').text('Create Category');
            // Tampilkan modal
            $('#categoryModal').modal('show');
        }

        function closeModal() {
            $('#categoryModal').modal('hide');
        }
</script>
@endsection