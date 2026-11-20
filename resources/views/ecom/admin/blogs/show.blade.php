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
                {{-- <a href="{{ route('ecomadmin.orders.create') }}"
                    class="btn btn-primary float-end mt-3">
                    New <i class="bi bi-plus-lg"></i>
                </a> --}}
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

        <div class="container rounded bg-white">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div
                        class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle" width="150px"
                            src="{{ $customer->avatar ?? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}"><span
                            class="font-weight-bold">{{ $customer->name }}
                            {{ $customer->last_name }}</span><span
                            class="text-black-50">{{ $customer->email }}</span><span>
                        </span>
                    </div>
                </div>
                <div class="col-md-5 border-right" id="user_detail">
                    <div class="p-3 py-5">
                        {{-- <div
                            class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <label class="labels">Name</label>
                                <input type="text" class="form-control"
                                    placeholder="first name"
                                    value="{{ $customer->name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Surname</label>
                                <input type="text" class="form-control"
                                    value="{{ $customer->last_name }}"
                                    placeholder="surname">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">Mobile
                                    Number</label>
                                <input type="text" class="form-control"
                                    placeholder="enter phone number"
                                    value="{{ $customer->phone }}">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Email</label>
                                <input type="text" class="form-control"
                                    placeholder="enter email id"
                                    value="{{ $customer->email }}">
                            </div>
                            {{-- <div class="col-md-12">
                                <label class="labels">Address Line 1</label>
                                <input type="text" class="form-control"
                                    placeholder="enter address line 1"
                                    value="">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Address Line 2</label>
                                <input type="text" class="form-control"
                                    placeholder="enter address line 2"
                                    value="">
                            </div>
                            <div class="col-md-12"><label
                                    class="labels">Postcode</label>
                                <input type="text" class="form-control"
                                    placeholder="enter address line 2"
                                    value="">
                            </div>
                            <div class="col-md-12"><label
                                    class="labels">State</label><input
                                    type="text" class="form-control"
                                    placeholder="enter address line 2"
                                    value=""></div>
                            <div class="col-md-12"><label
                                    class="labels">Area</label><input
                                    type="text" class="form-control"
                                    placeholder="enter address line 2"
                                    value=""></div>
                            <div class="col-md-12">
                                <label class="labels">Email
                                    ID</label><input type="text"
                                    class="form-control"
                                    placeholder="enter email id"
                                    value="">
                            </div>
                            <div class="col-md-12"><label
                                    class="labels">Education</label><input
                                    type="text" class="form-control"
                                    placeholder="education" value="">
                            </div> --}}
                        </div>

                        {{-- <div class="row mt-3">
                            <div class="col-md-6"><label
                                    class="labels">Country</label><input
                                    type="text" class="form-control"
                                    placeholder="country" value=""></div>
                            <div class="col-md-6"><label
                                    class="labels">State/Region</label><input
                                    type="text" class="form-control"
                                    value="" placeholder="state"></div>
                        </div>
                        <div class="mt-5 text-center"><button
                                class="btn btn-primary profile-button"
                                type="button">Save Profile</button></div> --}}
                    </div>
                </div>
                <div class="col-md-4" id="user_detail2">
                    <div class="p-3 py-5">
                        <div
                            class="d-flex justify-content-between align-items-center experience">
                            <span>Address</span>
                            {{-- <span
                                class="border px-3 p-1 add-experience"><i
                                    class="fa fa-plus"></i>&nbsp;Experience</span> --}}
                        </div><br>
                        {{-- <div class="col-md-12"><label class="labels">Experience
                                in
                                Designing</label><input type="text"
                                class="form-control" placeholder="experience"
                                value=""></div> <br>
                        <div class="col-md-12"><label class="labels">Additional
                                Details</label><input type="text"
                                class="form-control"
                                placeholder="additional details"
                                value=""></div> --}}

                        <div class="col-md-12">
                            <address>
                                {{ $customer->defaultAddress->address }}
                            </address>
                            {{-- {{ $customer->defaultAddress->city }},
                            {{ $customer->defaultAddress->state }},
                            {{ $customer->defaultAddress->country }},
                            {{ $customer->defaultAddress->zip }} --}}
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
