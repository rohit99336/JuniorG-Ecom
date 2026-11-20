@extends('ecom.web.layouts.app')

@section('meta')
    <title>Junior-G Cart: User Profile</title>
    <meta name="description"
        content="Manage your user profile on Junior-G Cart. Update account information, change password, and view your order history.">
    <meta name="keywords"
        content="Junior-G Cart, Baby Products, User Profile, Update Account, Change Password, Order History">
@endsection

@section('styles')
@endsection

@section('content')
    @include('ecom.web.layouts.bradcamp')

    <main id="MainContent" class="content-for-layout">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="checkout-wrapper">
                        <div id="faq" class="accordion">

                            @include('ecom.web.layouts.messages')

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne"
                                        aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Edit account information
                                    </button>
                                </h2>
                                <div id="collapseOne"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne"
                                    data-bs-parent="#faq">
                                    <div class="accordion-body">
                                        <form
                                            action="{{ route('shop.updateprofile', $customer->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label
                                                        for="input-first-name"
                                                        class="form-label">First
                                                        Name</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="input-first-name"
                                                        name="name"
                                                        value="{{ $customer->name ?? old('name') }}"
                                                        autofocus>
                                                </div>
                                                <div class="col-md-6">
                                                    <label
                                                        for="input-last-name"
                                                        class="form-label">Last
                                                        Name</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="input-last-name"
                                                        name="last_name"
                                                        value="{{ $customer->last_name ?? old('last_name') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="dob"
                                                        class="form-label">Date
                                                        of Birth</label>
                                                    <input type="date"
                                                        class="form-control"
                                                        id="dob"
                                                        name="dob"
                                                        value="{{ $customer->dob }}"
                                                        placeholder="Select your dob">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="gender"
                                                        class="form-label">Gender</label>
                                                    <select class="form-select"
                                                        id="gender"
                                                        name="gender">
                                                        <option value="">
                                                            Select Gender
                                                        </option>
                                                        <option value="male"
                                                            {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>
                                                            Male
                                                        </option>
                                                        <option value="female"
                                                            {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>
                                                            Female
                                                        </option>
                                                        <option value="other"
                                                            {{ old('gender', $customer->gender) == 'other' ? 'selected' : '' }}>
                                                            Other
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="input-email"
                                                        class="form-label">Email
                                                        Address</label>
                                                    <input type="email"
                                                        class="form-control"
                                                        id="input-email"
                                                        name="email"
                                                        value="{{ $customer->email ?? old('email') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="input-phone"
                                                        class="form-label">Contact
                                                        Number</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="input-phone"
                                                        name="phone"
                                                        value="{{ $customer->phone ?? old('phone') }}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        minlength="10"
                                                        maxlength="10">
                                                </div>
                                                <div class="col-12">
                                                    <label for="input-address"
                                                        class="form-label">Address</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="input-address"
                                                        name="address"
                                                        placeholder="Address"
                                                        value="{{ $address->address ?? old('address') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="state_id"
                                                        class="form-label">State</label>
                                                    <select class="form-select"
                                                        id="state_id"
                                                        name="state_id">
                                                        <option value="">
                                                            Select State
                                                        </option>
                                                        @foreach ($states as $state)
                                                            <option
                                                                value="{{ $state->id }}"
                                                                {{ $state->id == ($address->state_id ?? '') ? 'selected' : '' }}>
                                                                {{ $state->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="city_id"
                                                        class="form-label">City</label>
                                                    <select
                                                        class="form-select"
                                                        id="city_id"
                                                        name="city_id">
                                                        <option
                                                            value="">
                                                            Select City
                                                        </option>
                                                        @foreach ($cities as $city)
                                                            <option
                                                                value="{{ $city->id }}"
                                                                {{ $city->id == ($address->city ?? '') ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label
                                                        for="input-postal-code"
                                                        class="form-label">Postal
                                                        Code</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="input-postal-code"
                                                        name="zip_code"
                                                        placeholder="Postal code"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        value="{{ $address->zip ?? '' }}"
                                                        minlength="6"
                                                        maxlength="6">
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <button type="submit"
                                                    class="btn btn-primary">Update
                                                    Profile</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo"
                                        aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Change your password
                                    </button>
                                </h2>
                                <div id="collapseTwo"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo"
                                    data-bs-parent="#faq">
                                    <div class="accordion-body">
                                        <form
                                            action="{{ route('shop.changePassword') }}"
                                            method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="old_password"
                                                    class="form-label">Old
                                                    Password</label>
                                                <input type="password"
                                                    class="form-control"
                                                    id="old_password"
                                                    name="old_password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password"
                                                    class="form-label">New
                                                    Password</label>
                                                <input type="password"
                                                    class="form-control"
                                                    id="password"
                                                    name="password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="confirm_password"
                                                    class="form-label">Confirm
                                                    Password</label>
                                                <input type="password"
                                                    class="form-control"
                                                    id="confirm_password"
                                                    name="confirm_password">
                                            </div>
                                            <div class="mt-3">
                                                <button type="submit"
                                                    class="btn btn-primary">Change
                                                    Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header"
                                    id="headingThree">
                                    <button class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree"
                                        aria-expanded="false"
                                        aria-controls="collapseThree">
                                        My Orders
                                    </button>
                                </h2>
                                <div id="collapseThree"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="headingThree"
                                    data-bs-parent="#faq">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Order Id</th>
                                                        <th>No. of Items</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $key => $order)
                                                        <tr>
                                                            <td>{{ $key + 1 }}
                                                            </td>
                                                            <td><a
                                                                    href="{{ route('shop.orderdetail', $order->order_number) }}">{{ $order->order_number }}</a>
                                                            </td>
                                                            <td>{{ $order->orderItems->count() }}
                                                            </td>
                                                            <td>₹
                                                                {{ $order->total }}
                                                            </td>
                                                            <td>{{ ucfirst($order->status) }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('shop.orderdetail', $order->order_number) }}"
                                                                    class="btn btn-primary"
                                                                    title="See Order Detail">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16"
                                                                        height="16"
                                                                        fill="white"
                                                                        class="bi bi-eye"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                                        <path
                                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                                    </svg>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- Pagination -->
                                            {{ $orders->appends(request()->except('page'))->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // get states based on country
            $('#country_id').on('change', function() {
                var country_id = $(this).val();
                $("#state_id").html('');
                $.ajax({
                    url: "{{ route('states') }}",
                    type: "GET",
                    data: {
                        country_id: country_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state_id').html(
                            '<option value="">Select State</option>'
                        );
                        $.each(result.states,
                            function(key,
                                value) {
                                $("#state_id")
                                    .append(
                                        '<option value="' +
                                        value
                                        .id +
                                        '">' +
                                        value
                                        .name +
                                        '</option>'
                                    );
                            });
                    },
                    error: function(xhr, status,
                        error) {
                        console.error(xhr
                            .responseText);
                    }
                });
            });

            // get cities based on state
            $('#state_id').on('change', function() {
                var state_id = $(this).val();
                $("#city_id").html('');
                $.ajax({
                    url: "{{ route('cities') }}",
                    type: "GET",
                    data: {
                        state_id: state_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city_id').html(
                            '<option value="">Select City</option>'
                        );
                        $.each(result.cities,
                            function(key,
                                value) {
                                $("#city_id")
                                    .append(
                                        '<option value="' +
                                        value
                                        .id +
                                        '">' +
                                        value
                                        .name +
                                        '</option>'
                                    );
                            });
                    },
                    error: function(xhr, status,
                        error) {
                        console.error(xhr
                            .responseText);
                    }
                });
            });

            $('#input-phone').on('change', function() {
                var inputValue = $(this).val();
                var pattern = /^(6|7|8|9)\d{9}$/;

                if (!pattern.test(inputValue)) {
                    alert(
                        'Please enter a valid Indian phone number starting with 6, 7, 8, or 9 and having exactly 10 digits.'
                    );
                }
            });

            // Set default date to 10 years ago
            var tenYearsAgo = new Date();
            tenYearsAgo.setFullYear(tenYearsAgo.getFullYear() - 10);
            var tenYearsAgoFormatted = tenYearsAgo.toISOString().split(
                'T')[0];
            $('#dob').attr('max', tenYearsAgoFormatted).val(
                tenYearsAgoFormatted);

            // Set default time to now
            var now = new Date();
            var hh = now.getHours().toString().padStart(2, '0');
            var mm = now.getMinutes().toString().padStart(2, '0');
            var nowFormatted = hh + ':' + mm;
            $('#schedule_time').attr('min', nowFormatted);
        });
    </script>
@endsection
