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
                                <h2 class="section-heading">Payment</h2>
                            </div>

                            <div class="checkout-progress overflow-hidden">
                                <!-- Checkout progress steps -->
                                <ol class="checkout-bar px-0">
                                    <!-- Steps with links -->
                                    <li class="progress-step step-done"><a
                                            href="{{ route('shop.cart') }}">Cart</a>
                                    </li>
                                    <li class="progress-step step-done"><a
                                            href="javascript:void(0)">Your
                                            Details</a></li>
                                    <li class="progress-step step-done"><a
                                            href="javascript:void(0)">Shipping</a>
                                    </li>
                                    <li
                                        class="progress-step step-todo step-active">
                                        <a
                                            href="javascript:void(0)">Payment</a>
                                    </li>
                                    <li class="progress-step step-todo"><a
                                            href="javascript:void(0)">Review</a>
                                    </li>
                                </ol>
                            </div>

                            <!-- Payment methods -->
                            <div class="payment-methods mt-5">
                                <h3 class="mb-4">Choose Payment Method</h3>

                                <div class="row">
                                    <!-- Payment method: Cash on Delivery (COD) -->
                                    <div class="col-md-4 mb-4">
                                        <div class="card payment-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Cash on
                                                    Delivery (COD)</h5>
                                                <p class="card-text">Pay with
                                                    cash upon delivery.</p>
                                                <a href="javascript:void(0);" id="cod_btn"
                                                    class="btn btn-primary">Select
                                                    COD</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment method: Razorpay -->
                                    <div class="col-md-4 mb-4">
                                        <div class="card payment-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Razorpay
                                                </h5>
                                                <p class="card-text">Secure
                                                    online payment via
                                                    Razorpay.</p>
                                                <a href="javascript:void(0);" id="razorpay_btn"
                                                    class="btn btn-primary">Pay
                                                    with Razorpay</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment method: Google Pay -->
                                    <div class="col-md-4 mb-4">
                                        <div class="card payment-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Google
                                                    Pay</h5>
                                                <p class="card-text">Fast and
                                                    easy payment with Google
                                                    Pay.</p>
                                                <a href="javascript:void(0);" id="g-pay_btn"
                                                    class="btn btn-primary">Pay
                                                    with Google Pay</a>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="" method="POST" hidden id="pay_req">
                                        @csrf
                                        <input type="hidden" name="paymentMethod"
                                            value="cod">
                                        <input type="hidden" name="order_id"
                                            value="{{ $order->id }}">
                                        <input type="hidden" name="order_number"
                                            value="{{ $order->order_number }}">
                                        <input type="hidden" name="amount"
                                            value="{{ $order->total }}">
                                        <input type="hidden" name="customer_id"
                                            value="{{ $order->customer->customer_id }}">
                                        <input type="hidden" name="name"
                                            value="{{ $order->customer->name }}">
                                        <input type="hidden" name="email"
                                            value="{{ $order->customer->email }}">
                                        <input type="hidden" name="mobile"
                                            value="{{ $order->billingAddress->phone }}">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                            <div class="cart-total-area checkout-summary-area">
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
        // window.history.forward();
        $(document).ready(function() {
            // Disable the back button
            window.history.pushState(null, "", window
                .location.href);
            window.onpopstate = function() {
                window.history.pushState(null, "",
                    window.location.href);
            };
        });
        $(document).ready(function() {
            // if click fire_rzrp button then submit the form
            $("#cod_btn").click(function() {
                // set action route and submit the form
                $route = "{{ route('shop.payment.cod') }}";
                $("#pay_req").attr('action', $route);

                // set paymentMethod and amount
                $("#pay_req").find(
                    'input[name="paymentMethod"]').val(
                    'cod');

                $("#pay_req").submit();
            });

        });
    </script>
@endsection
