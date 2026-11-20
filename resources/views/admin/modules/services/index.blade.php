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
                                <a href="{{ route('services.create') }}" class="btn btn-primary float-end">
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
                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Variants</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                ajax: '{{ route('services.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'no_of_variants',
                        name: 'no_of_variants'
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
                var url = '{{ route('services.destroy', ':id') }}';
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



{{-- @section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>{{ $title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">

                        <div class="row card-title">
                            <div class="col-md-6">
                                <h5 class="ms-4">{{ $subTitle }}</h5>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Order No.</th>
                                            <th>Customer</th>
                                            <th>Product</th>
                                            <th>Price(₹)</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Order Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->order_number }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->product->price }}</td>
                                                <td>{{ $item->product->size_id }}</td>
                                                <td class="text-center">
                                                    @foreach ($item->orderItems as $orderItem)
                                                        <!-- show only 1st item quantity -->
                                                        {{ $loop->first ? $orderItem->quantity : '' }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $item->total }}
                                                </td>
                                                <td>{{ ucfirst($item->status) }}</td>
                                                <td nowrap>{{ $item->created_at->format('d-m-Y') }}</td>
                                                <td nowrap>
                                                    <a href="{{ route('admin.order.show', $item->id) }}"
                                                        class="btn btn-primary btn-xs" title="Order Detail" >
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.order.edit', $item->id) }}"
                                                        class="btn btn-warning btn-xs" title="Edit Order" >
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.order.destroy', $item->id) }}"
                                                        method="POST" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-xs" title="Delete Order"
                                                            onclick="return confirm('Are you sure to delete this item?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            <!-- Place the pagination links outside the table -->
                            <div class="d-flex justify-content-center mt-3">
                                {!! $orders->links() !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>
@endsection --}}
