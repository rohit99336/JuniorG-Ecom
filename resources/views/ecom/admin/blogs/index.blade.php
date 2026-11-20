@extends('ecom.admin.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('ecomadmin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="card-title row">
                    <div class="col-6">
                        <h5 class="card-title">{{ $title }}</h5>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('ecomadmin.blog.blogs.create') }}" class="btn btn-primary float-end mt-3">
                            New <i class="bi bi-plus-lg"></i>
                        </a>
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

                <div class="table-responsive">
                    <table class="table datatable display nowrap"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" onchange="">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Creaded Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });

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
                scrollX: true,

                ajax: '{{ route('ecomadmin.blog.blogs.index') }}',
                columns: [{
                        data: 'sr_no',
                        name: 'sr_no'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
        });

        // Delete State if clicked class delete
        $(document).on('click', '.delete', function() {
            var id = $(this).attr('id');
            var url =
                '{{ route('ecomadmin.blog.blogs.destroy', ':id') }}';
            var newUrl = url.replace(':id', id);
            var token = '{{ csrf_token() }}';

            if (confirm(
                    'Are you sure you want to delete this?'
                )) {
                $.ajax({
                    url: newUrl,
                    method: 'DELETE',
                    data: {
                        id: id,
                        _token: token
                    },
                    success: function(data) {
                        alert(data.message);
                        // // reload the page
                        // location.reload();

                        $('.datatable')
                            .DataTable().ajax
                            .reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                return false;
            }
        });


        function changeStatus(select) {
            var orderId = $(select).data('id');
            var newStatus = select.value;
            var token = '{{ csrf_token() }}';

            if (confirm('Are you sure you want to change status?')) {
                $.ajax({
                    url: '{{ route('ecomadmin.updateStatus') }}',
                    method: 'POST',
                    data: {
                        order_id: orderId,
                        status: newStatus,
                        _token: token
                    },
                    success: function(response) {
                        console.log(response);
                        alert(response.message);
                        $('.datatable')
                            .DataTable().ajax
                            .reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }
    </script>
@endsection
