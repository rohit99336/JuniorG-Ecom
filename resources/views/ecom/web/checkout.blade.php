@extends('ecom.web.layouts.app')

@section('meta')
    <title>Shopping Cart - ShriVenu Naturals</title>
    <meta name="keywords"
        content="shopping cart, ShriVenu Naturals cart, view cart, check out, shopping bag">
    <meta name="description"
        content="Review your selected items in the shopping cart at ShriVenu Naturals. Easily manage your purchases, add or remove items, and proceed to checkout to complete your order. Shop now for natural wellness products and enjoy a seamless shopping experience!">
@endsection

@section('styles')
@endsection

@section('content')
    <!-- get cart data from session -->
    @php
        $cartData = session()->get('cart');
        $user = auth()->guard('customer')->user();
        // dd($cartData);
        $total = 0; // Initializing total
        $grandTotal = 0;
        $noOfItems = 0;
        $shippingCharge = $ecomProps->shipping_charge;
        $free_shipping_amount = $ecomProps->free_shipping_amount;

        if ($cartData && count($cartData) > 0) {
            $noOfItems = count($cartData);
            // Null check and count check
            foreach ($cartData as $item) {
                // Assuming each $item is an associative array with 'price' and 'quantity' keys
                $total += $item['price'] * $item['quantity'];
                $grandTotal = $total;
            }
        }

        // if total is greater than or equal to free shipping amount, then shipping charge is 0 else shipping charge is $shippingCharge and add it to grand total
        if ($total >= $free_shipping_amount) {
            $shippingCharge = 0;
        } else {
            $grandTotal += $shippingCharge;
        }

    @endphp

    @include('ecom.web.layouts.bradcamp')

    <main id="MainContent" class="content-for-layout">
        <div class="checkout-page mt-100">
            <div class="container">
                <div class="checkout-page-wrapper">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                            <div class="section-header mb-3">
                                <h2 class="section-heading">Check out</h2>
                            </div>

                            <div class="checkout-progress overflow-hidden">
                                <ol class="checkout-bar px-0">
                                    <li class="progress-step step-done"><a
                                            href="{{ route('shop.cart') }}">Cart</a>
                                    </li>
                                    <li class="progress-step step-done"><a
                                            href="javascript:void(0)">Your
                                            Details</a></li>
                                    <li
                                        class="progress-step step-todo step-active">
                                        <a
                                            href="javascript:void(0)">Shipping</a>
                                    </li>
                                    <li class="progress-step step-todo"><a
                                            href="checkout.html">Payment</a>
                                    </li>
                                    <li class="progress-step step-todo"><a
                                            href="checkout.html">Review</a>
                                    </li>
                                </ol>
                            </div>

                            <div
                                class="checkout-user-area overflow-hidden d-flex align-items-center">
                                <div class="checkout-user-img me-4">
                                    <img src="{{ asset($user->avatar ?? 'ecom/web/assets/img/checkout/user.webp') }}"
                                        alt="{{ ucfirst($user->name) }}">
                                </div>

                                <div
                                    class="checkout-user-details d-flex align-items-center justify-content-between w-100">
                                    <div class="checkout-user-info">
                                        <h2 class="checkout-user-name">
                                            {{ ucfirst($user->name) }}
                                        </h2>
                                        <p class="checkout-user-address mb-0">
                                            {{ $user->address ?? 'NA' }}
                                        </p>
                                    </div>

                                    <a href="#"
                                        class="edit-user btn-secondary">EDIT
                                        PROFILE</a>
                                </div>
                            </div>

                            {{-- @include('ecom.web.layouts.messages') --}}
                            <div id="errors" class="mt-5"></div>

                            <div class="shipping-address-area shipping-area">
                                <h2 class="shipping-address-heading pb-1">
                                    Billing address</h2>
                                <div class="shipping-address-form-wrapper">
                                    <form action="#"
                                        class="shipping-address-form common-form">
                                        <div class="row">
                                            <input type="hidden"
                                                name="billing_adr_id"
                                                id="billing_adr_id"
                                                value="{{ $billing_address->id ?? '' }}">
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">First
                                                        name<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        value="{{ $billing_address->first_name ?? old('billing[first_name]') }}"
                                                        name="billing[first_name]"
                                                        id="billing_first_name"
                                                        required />
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">Last
                                                        name<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        value="{{ $billing_address->last_name ?? old('billing[last_name]') }}"
                                                        name="billing[last_name]"
                                                        id="billing_last_name"
                                                        required />
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">Email
                                                        address<span
                                                            class="text-danger">*</span></label>
                                                    <input type="email"
                                                        name="billing[email]"
                                                        value="{{ $billing_address->email ?? old('billing[email]') }}"
                                                        id="billing_email"
                                                        required />
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">Phone
                                                        number<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        name="billing[phone]"
                                                        value="{{ $billing_address->phone ?? old('phone') }}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        minlength="10"
                                                        maxlength="10"
                                                        id="billing_phone" />
                                                </fieldset>
                                            </div>
                                            {{-- <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label
                                                        class="label">Company</label>
                                                    <input type="text" />
                                                </fieldset>
                                            </div> --}}
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">
                                                        State<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select"
                                                        name="billing[state_id]"
                                                        id="billing_state_id">
                                                        @foreach ($states as $key => $state)
                                                            @if ($billing_address)
                                                                <option
                                                                    value="{{ $state->id }}"
                                                                    {{ $billing_address->state_id == $state->id ? 'selected' : '' }}>
                                                                    {{ $state->name }}
                                                                </option>
                                                            @else
                                                                <option
                                                                    value="{{ $state->id }}">
                                                                    {{ $state->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label
                                                        class="label">City<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select"
                                                        name="billing[city]"
                                                        id="billing_city">
                                                        @foreach ($cities as $key => $city)
                                                            @if ($billing_address)
                                                                <option
                                                                    value="{{ $city->name }}"
                                                                    {{ $billing_address->city == $city->name ? 'selected' : '' }}>
                                                                    {{ $city->name }}
                                                                </option>
                                                            @else
                                                                <option
                                                                    value="{{ $city->name }}">
                                                                    {{ $city->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">
                                                        Zip code<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                        name="billing[zip]"
                                                        value="{{ $billing_address->zip ?? old('billing[zip]') }}"
                                                        required
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        minlength="6"
                                                        maxlength="6"
                                                        id="billing_zip" />
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">
                                                        Address<span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                        class="required"
                                                        name="billing[address]"
                                                        value="{{ $billing_address->address ?? old('billing[address]') }}"
                                                        id="billing_address" />
                                                </fieldset>
                                            </div>
                                            {{-- <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label
                                                        class="label">Address
                                                        2</label>
                                                    <input type="text" />
                                                </fieldset>
                                            </div> --}}
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <div class="shipping-address-area billing-area">
                                <h2 class="shipping-address-heading pb-1">
                                    Shipping address</h2>
                                <div
                                    class="form-checkbox d-flex align-items-center mt-4">
                                    <input class="form-check-input mt-0"
                                        type="checkbox" id="same_address">
                                    <label for="same_address"
                                        class="form-check-label ms-2">
                                        Same as billing address
                                    </label>
                                </div>

                                <div class="shipping-address-form-wrapper"
                                    id="shipping_address_div">
                                    <form action="#"
                                        class="shipping-address-form common-form">
                                        <div class="row">
                                            <input type="hidden"
                                                name="shipping_adr_id"
                                                id="shipping_adr_id"
                                                value="{{ $shipping_address->id ?? '' }}">
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label
                                                        class="label">First
                                                        name</label>
                                                    <input type="text"
                                                        value="{{ $shipping_address->first_name ?? old('shipping[first_name]') }}"
                                                        name="shipping[first_name]"
                                                        id="shipping_first_name" />
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">Last
                                                        name</label>
                                                    <input type="text"
                                                        value="{{ $shipping_address->last_name ?? old('shipping[last_name]') }}"
                                                        name="shipping[last_name]"
                                                        id="shipping_last_name" />
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label
                                                        class="label">Email
                                                        address</label>
                                                    <input type="email"
                                                        name="shipping[email]"
                                                        value="{{ $shipping_address->email ?? old('shipping[email]') }}"
                                                        id="shipping_email" />
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label
                                                        class="label">Phone
                                                        number</label>
                                                    <input type="text"
                                                        name="shipping[phone]"
                                                        value="{{ $shipping_address->phone ?? old('phone') }}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        minlength="10"
                                                        maxlength="10"
                                                        id="shipping_phone" />
                                                </fieldset>
                                            </div>
                                            {{-- <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label
                                                        class="label">Company</label>
                                                    <input type="text" />
                                                </fieldset>
                                            </div> --}}
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">
                                                        State
                                                    </label>
                                                    <select
                                                        class="form-select"
                                                        name="shipping[state_id]"
                                                        id="shipping_state_id">
                                                        <option
                                                            value="">
                                                            Select state
                                                        </option>
                                                        @foreach ($states as $key => $state)
                                                            @if ($shipping_address)
                                                                <option
                                                                    value="{{ $state->id }}"
                                                                    {{ $shipping_address->state_id == $state->id ? 'selected' : '' }}>
                                                                    {{ $state->name }}
                                                                </option>
                                                            @else
                                                                <option
                                                                    value="{{ $state->id }}">
                                                                    {{ $state->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label
                                                        class="label">City</label>
                                                    <select
                                                        class="form-select"
                                                        id="shipping_city"
                                                        name="shipping[city]">
                                                        <option
                                                            value="">
                                                            Select city
                                                        </option>
                                                        @foreach ($cities as $key => $city)
                                                            @if ($shipping_address)
                                                                <option
                                                                    value="{{ $city->name }}"
                                                                    {{ $shipping_address->city == $city->name ? 'selected' : '' }}>
                                                                    {{ $city->name }}
                                                                </option>
                                                            @else
                                                                <option
                                                                    value="{{ $city->name }}">
                                                                    {{ $city->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">
                                                        Zip code
                                                    </label>
                                                    <input type="text"
                                                        name="shipping[zip]"
                                                        value="{{ $shipping_address->zip ?? old('shipping[zip]') }}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        minlength="6"
                                                        maxlength="6"
                                                        id="shipping_zip" />
                                                </fieldset>
                                            </div>
                                            <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label class="label">
                                                        Address
                                                    </label>
                                                    <input type="text"
                                                        name="shipping[address]"
                                                        value="{{ $shipping_address->address ?? old('shipping[address]') }}"
                                                        id="shipping_address" />
                                                </fieldset>
                                            </div>
                                            {{-- <div
                                                class="col-lg-6 col-md-12 col-12">
                                                <fieldset>
                                                    <label
                                                        class="label">Address
                                                        2</label>
                                                    <input type="text" />
                                                </fieldset>
                                            </div> --}}
                                        </div>

                                    </form>
                                </div>

                                <div
                                    class="shipping-address-area billing-area">
                                    <div
                                        class="minicart-btn-area d-flex align-items-center justify-content-between flex-wrap">
                                        <a href="{{ route('shop.cart') }}"
                                            class="checkout-page-btn minicart-btn btn-secondary">BACK
                                            TO CART</a>
                                        <a href="javascript:void(0)"
                                            id="proceed_to_payment"
                                            class="checkout-page-btn minicart-btn btn-primary">PROCEED
                                            TO PAYMENT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                            <div
                                class="cart-total-area checkout-summary-area">
                                <h3
                                    class="d-none d-lg-block mb-0 text-center heading_24 mb-4">
                                    Order summary
                                </h3>


                                @if (!empty($cartData) && count($cartData) > 0)
                                    @foreach ($cartData as $key => $item)
                                        <div class="minicart-item d-flex">
                                            <div class="mini-img-wrapper">
                                                <img class="mini-img"
                                                    src="{{ $item['image'] }}"
                                                    alt="{{ $item['name'] }}">
                                            </div>
                                            <div class="product-info">
                                                <h2 class="product-title">
                                                    <a
                                                        href="{{ route('shop.product', $item['product_variant_id']) }}">{{ ucfirst($item['name']) }}</a>
                                                </h2>
                                                <p class="product-vendor">
                                                    ₹{{ $item['price'] }}
                                                    x
                                                    {{ $item['quantity'] }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div
                                    class="cart-total-box mt-4 bg-transparent p-0">
                                    <div class="subtotal-item subtotal-box">
                                        <h4 class="subtotal-title">
                                            Subtotals:</h4>
                                        <p class="subtotal-value">
                                            ₹{{ $total }}
                                        </p>
                                    </div>
                                    <div class="subtotal-item shipping-box">
                                        <h4 class="subtotal-title">
                                            Shipping:</h4>
                                        <p class="subtotal-value">
                                            ₹{{ $shippingCharge }}
                                        </p>
                                    </div>
                                    {{-- <div
                                            class="subtotal-item discount-box">
                                            <h4 class="subtotal-title">
                                                Discount:</h4>
                                            <p class="subtotal-value">$100.00
                                            </p>
                                        </div> --}}
                                    <hr />
                                    <div class="subtotal-item discount-box">
                                        <h4 class="subtotal-title">Total:
                                        </h4>
                                        <p class="subtotal-value">
                                            ₹{{ $grandTotal }}
                                        </p>
                                    </div>


                                    <div class="mt-4 checkout-promo-code">
                                        <input class="input-promo-code"
                                            type="text"
                                            placeholder="Promo code" />
                                        <a href="checkout.html"
                                            class="btn-apply-code position-relative btn-secondary text-uppercase mt-3">
                                            Apply Promo Code
                                        </a>
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
                                        .name +
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

            $('#phone').on('change', function() {
                var inputValue = $(this).val();
                var pattern = /^(6|7|8|9)\d{9}$/;

                if (!pattern.test(inputValue)) {
                    alert(
                        'Please enter a valid Indian phone number starting with 6, 7, 8, or 9 and having exactly 10 digits.'
                    );
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Check or uncheck shipping address checkbox based on $shipping_address
            $("#ch_shipping_ad").prop("checked",
                {!! !empty($shipping_address) ? 'true' : 'false' !!});

            // Show or hide open toggle based on $shipping_address
            $('#shipping_address_div').hide();

            // Check or uncheck same address checkbox based on $shipping_address
            $("#same_address").prop("checked",
                {!! empty($shipping_address) ? 'true' : 'false' !!});

            // if shipping address is not empty then shippig address div will be shown
            if ({!!!empty($shipping_address)!!}) {
                $('#shipping_address_div').show();
            }

            // // same_address default to checked
            // $("#same_address").prop("checked", true);


            // $('#ch_shipping_ad').on('change', function() {
            //     if ($(this).is(':checked')) {
            //         $('#shipping_address_div').show();
            //         $('#same_address').prop('checked', false);
            //     } else {
            //         $('#shipping_address_div').hide();
            //         $('#same_address').prop('checked', true);
            //     }
            // });

            $('#same_address').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#shipping_address_div').hide();
                    $('#same_address').prop('checked', true);
                    // $('#ch_shipping_ad').prop('checked',
                    //     false);
                } else {
                    $('#shipping_address_div').show();
                    $('#same_address').prop('checked', false);
                    // $('#ch_shipping_ad').prop('checked', true);
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#proceed_to_payment').on('click', function() {
                // Check if all required fields are filled out
                var isValid = true;
                $('.required').each(function() {
                    if ($(this).val().trim() === '') {
                        isValid = false;
                        alert(
                            'Please fill out all required fields.'
                        );
                        return false; // Exit the loop early if any field is empty
                    }
                });

                if (!isValid) {
                    return; // Prevent further execution if validation fails
                }

                // // Retrieve input values
                // var firstName = $('#billing_first_name').val();

                // Make AJAX request
                $.ajax({
                    url: "{{ route('shop.order') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        billing_first_name: $(
                                '#billing_first_name')
                            .val(),
                        billing_last_name: $(
                                '#billing_last_name')
                            .val(),
                        billing_email: $(
                                '#billing_email')
                            .val(),
                        billing_phone: $(
                                '#billing_phone')
                            .val(),
                        billing_state_id: $(
                                '#billing_state_id')
                            .val(),
                        billing_city: $(
                            '#billing_city').val(),
                        billing_zip: $('#billing_zip')
                            .val(),
                        billing_address: $(
                                '#billing_address')
                            .val(),
                        shipping_first_name: $(
                                '#shipping_first_name')
                            .val(),
                        shipping_last_name: $(
                                '#shipping_last_name')
                            .val(),
                        shipping_email: $(
                                '#shipping_email')
                            .val(),
                        shipping_phone: $(
                                '#shipping_phone')
                            .val(),
                        shipping_state_id: $(
                                '#shipping_state_id')
                            .val(),
                        shipping_city: $(
                                '#shipping_city')
                            .val(),
                        shipping_zip: $(
                            '#shipping_zip').val(),
                        shipping_address: $(
                                '#shipping_address')
                            .val(),
                        same_address: $(
                            '#same_address').val()
                    },
                    dataType: 'json',
                    success: function(result) {
                        // Handle success response
                        console.log(result);
                        if (result.errors && result
                            .errors.length > 0) {
                            // Display errors in the #errors element
                            var errorList =
                                '<ul class="alert alert-danger">';
                            result.errors.forEach(
                                function(
                                    error) {
                                    errorList
                                        +=
                                        '<li class="text-danger">' +
                                        error +
                                        '</li>';
                                });
                            errorList += '</ul>';
                            $('#errors').html(
                                errorList);

                            // Scroll to the #errors element
                            $('html, body')
                                .animate({
                                    scrollTop: $(
                                            '#errors'
                                        )
                                        .offset()
                                        .top
                                }, 500);

                            return false;
                        } else {
                            // Clear any existing errors
                            $('#errors').empty();

                            // Redirect to the payment page with the order_id
                            window.location.href =
                                result
                                .payment_route;
                        }
                    },
                    error: function(xhr, status,
                        error) {
                        // Handle error response
                        console.error(xhr
                            .responseText);
                        alert(
                            'An error occurred while processing your request.'
                        );
                    }
                });
            });
        });
    </script>
@endsection
