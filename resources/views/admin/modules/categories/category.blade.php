@extends('admin.layouts.app')


@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('ecomadmin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title row">
                            <div class="col-md-6">
                                <h5 class="card-title">{{ $title }}</h5>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary float-end" data-bs-toggle="modal"
                                    data-bs-target="#category-add">
                                    <i class="bi bi-plus-lg"></i> New
                                </button>
                            </div>
                        </div>

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="category-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="category-addLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="category-addLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row mb-1">
                                <label for="inputText">Category</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name" autofocus>
                                </div>

                                <input type="hidden" name="id" id="id">
                            </div>

                            <div class="row mb-3">
                                <label for="description">Description</label>
                                <div class="col-sm-12">
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var dataTable = $('.datatable').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],

                // change page length title entries to Entries _MENU_
                language: {
                    lengthMenu: 'Entries _MENU_',
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>'
                    }
                },

                // Data Tables server side
                processing: true,
                serverSide: true,
                // scrollX: true,
                ajax: '{{ route('categories.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],

                // action column not sortable
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }],
            });

            // Edit State if clicked class edit
            $(document).on('click', '.edit', function() {
                var id = $(this).attr('id');
                var url = '{{ route('categories.edit', ':id') }}';
                var newUrl = url.replace(':id', id);
                var token = '{{ csrf_token() }}';

                $.ajax({
                    url: newUrl,
                    method: 'GET',
                    data: {
                        id: id,
                        _token: token
                    },
                    success: function(response) {
                        let data = response.data;
                        console.log(data);

                        // change category-addLabel title
                        $('#category-addLabel').text('Edit Category');

                        $('#category-add').modal('show');
                        $('#category-add #id').val(data.id);
                        $('#category-add #name').val(data.name);
                        $('#category-add #description').val(data.description);

                        // // add method put to update
                        // $('#category-add form').attr('method', 'PUT');

                        // change submit button text
                        $('#category-add button[type=submit]').text('Update');

                        // change action form
                        $('#category-add form').attr('action',
                            '{{ route('categories.update', ':id') }}'.replace(':id', data
                                .id));

                        // add new input name method put
                        $('#category-add form').append(
                            '<input type="hidden" name="_method" value="PUT">');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // Delete State if clicked class delete
            $(document).on('click', '.delete', function() {
                var id = $(this).attr('id');
                var url = '{{ route('categories.destroy', ':id') }}';
                var newUrl = url.replace(':id', id);
                var token = '{{ csrf_token() }}';

                if (confirm('Are you sure you want to delete this?')) {
                    $.ajax({
                        url: newUrl,
                        method: 'DELETE',
                        data: {
                            id: id,
                            _token: token
                        },
                        success: function(data) {
                            alert(data.message);
                            $('.datatable').DataTable().ajax.reload();
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                } else {
                    return false;
                }
            });

            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>
@endsection
