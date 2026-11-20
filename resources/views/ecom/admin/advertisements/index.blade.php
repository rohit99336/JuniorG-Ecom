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
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Screen</th>
                                        <th scope="col">Description</th>
                                        <th scope="col" nowrap>Action</th>
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

    @include('ecom.admin.advertisements.create')
@endsection

@section('script')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/filemanager.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#lfm').filemanager('file');

            // Listen for changes in the file input
            $('#image').change(function() {
                var imageUrl = $(this).val();
                $('#img_holder').attr('src', imageUrl);
            });
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
                ajax: '{{ route('ecomadmin.advertisement.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'media',
                        name: 'media'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-nowrap'
                    },
                ],

                // action column not sortable
                columnDefs: [{
                    targets: -1,
                    orderable: false
                    // className: 'text-nowrap'
                }],
            });

            // Delete State if clicked class delete
            $(document).on('click', '.delete', function() {
                var id = $(this).attr('id');
                var url = '{{ route('ecomadmin.advertisement.destroy', ':id') }}';
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
                var url = '{{ route('ecomadmin.advertisement.edit', ':id') }}';
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

                        // change uint-addLabel title
                        $('#uint-addLabel').text('Edit Advertisement');

                        $('#uint-add').modal('show');
                        $('#uint-add #id').val(data.id);
                        $('#uint-add #for').val(data.for);
                        $('#uint-add #title').val(data.title);
                        $('#uint-add #image').val(data.image);
                        $('#uint-add #description').val(data.description);
                        $('#uint-add #media').val(data.media);
                        $('#uint-add #button_text').val(data.button_text);
                        $('#uint-add #button_url').val(data.button_url);
                        $('#uint-add #start_date').val(data.start_date);
                        $('#uint-add #end_date').val(data.end_date);

                        if (data.image) {
                            $('#img_holder').attr('src', data.image);
                        }

                        if (data.id == 1) {
                            // $('#uint-add #for').prop('disabled', true);
                            $('#size').text('(1500x1136)');
                        } else {
                            $('#size').text('(1000x1205)');
                        }


                        // change submit button text
                        $('#uint-add button[type=submit]').text('Update');

                        // change action form
                        $('#uint-add form').attr('action',
                            '{{ route('ecomadmin.advertisement.update', ':id') }}'.replace(
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
                $('#uint-addLabel').text('New Advertisement');
            });

            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>
@endsection
