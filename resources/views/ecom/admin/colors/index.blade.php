@extends('ecom.admin.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('ecomadmin.dashboard') }}">Home</a></li>
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
                                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#uint-add">
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
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Color Code</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('ecom.admin.colors.create')
@endsection

@section('script')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/filemanager.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#lfm').filemanager('file');
        })
    </script>


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
                ajax: '{{ route('ecomadmin.prod.colors.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'color',
                        name: 'color'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
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

            // Delete State if clicked class delete
            $(document).on('click', '.delete', function() {
                var id = $(this).attr('id');
                var url = '{{ route('ecomadmin.prod.colors.destroy', ':id') }}';
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
                            alert(data.success);
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

            // Edit State if clicked class edit
            $(document).on('click', '.edit', function() {
                var id = $(this).attr('id');
                var url = '{{ route('ecomadmin.prod.colors.edit', ':id') }}';
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
                        // change uint-addLabel title
                        $('#uint-addLabel').text('Edit color detail');
                        $('#uint-add').modal('show');
                        $('#uint-add #id').val(data.id);
                        $('#uint-add #name').val(data.name);
                        $('#uint-add #code').val(data.code);
                        $('#uint-add #color_code').val(data.code);

                        // set select dropdown value in id status
                        $('#uint-add #status').val(data.is_active);

                        // change submit button text
                        $('#uint-add button[type=submit]').text('Update');

                        // change action form
                        $('#uint-add form').attr('action',
                            '{{ route('ecomadmin.prod.colors.update', ':id') }}'.replace(
                                ':id', data.id));

                        // add new input name method put
                        $('#uint-add form').append(
                            '<input type="hidden" name="_method" value="PUT">');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // if click reset button
            $(document).on('click', '#reset', function() {
                // change uint-addLabel title
                $('#uint-addLabel').text('New color');
            });

            // get code value and set to color_code
            $(document).on('change', '#code', function() {
                let code = $(this).val();
                $('#color_code').val(code);
            });

            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>
@endsection
