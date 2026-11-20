@extends('ecom.admin.layouts.app')

@section('style')
@endsection

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
        <div class="row mb-2">
            <div class="col-6">
                <h5 class="card-title">{{ $title }}</h5>
            </div>
            <div class="col-6">
                <a href="{{ route('ecomadmin.posts.index') }}"
                    class="btn btn-primary float-end mt-3">
                    Back <i class="bi bi-arrow-back"></i>
                </a>
            </div>
        </div>

        <div class="container rounded bg-white">
            <div class="row">
                <div class="col-12 m-5">
                    <div class="mb-3">
                        <h3>Title:</h3> {{ $post->title }}
                    </div>
                    <div>
                        <h3>Content:</h3> {!! $post->body !!}
                    </div>
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

            // //check route name
            // if (window.location.pathname.includes('orders')) {
            //     $('.nav-link').removeClass('active');
            //     $('#orders').addClass('active');
            // }

            var currentUrl = "{{ url()->current() }}";
            var currentRouteName = "{{ Route::currentRouteName() }}";

            console.log("Current URL:", currentUrl);
            console.log("Current Route Name:", currentRouteName);

            if (currentRouteName == 'ecomadmin.customers.show') {
                // user_detail form desable
                $('#user_detail input').attr('disabled', 'disabled');
                $('#user_detail input2').attr('disabled', 'disabled');
            }
        });

        $('.dropdown-item').on('click', function(e) {
            // e.preventDefault();
            // var orderId = $(this).closest(
            //     '.dropdown-menu').find(
            //     '.dropdown-item').data(
            //     'id');

            // console.log(orderId);
            // var newStatus = $(this).data(
            //     'status');
            // console.log(newStatus);

            let orderId = $(this).data('id');
            let newStatus = $(this).data('status');
            var token = '{{ csrf_token() }}';

            if (confirm(
                    'Are you sure you want to change status?'
                )) {

                $.ajax({
                    url: '{{ route('ecomadmin.updateStatus') }}',
                    method: 'POST',
                    // type: 'POST',
                    data: {
                        order_id: orderId,
                        status: newStatus,
                        _token: token
                    },
                    success: function(
                        response) {
                        console.log(
                            response
                        );
                        alert(response.message);

                        // reload the page
                        location.reload();
                    },
                    error: function(xhr,
                        status, error
                    ) {
                        console.error(
                            error);
                    }
                });
            } else {
                return false;
            }
        });
    </script>
@endsection
