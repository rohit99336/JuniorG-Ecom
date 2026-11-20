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

    @include('ecom.web.layouts.bradcamp')

    <main id="MainContent" class="content-for-layout">
        <div class="checkout-page mt-100">
            <div class="container">
                <div class="checkout-page-wrapper">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="section-header mb-3">
                                <h2 class="section-heading">Order Complete</h2>
                            </div>

                            <div class="checkout-progress overflow-hidden">
                                <!-- Checkout progress steps -->
                                <ol class="checkout-bar px-0">
                                    <!-- Steps with links -->
                                    <li class="progress-step step-done"><a href="{{ route('shop.cart') }}">Cart</a></li>
                                    <li class="progress-step step-done"><a href="javascript:void(0)">Your Details</a></li>
                                    <li class="progress-step step-done"><a href="javascript:void(0)">Shipping</a></li>
                                    <li class="progress-step step-done"><a href="javascript:void(0)">Payment</a></li>
                                    <li class="progress-step step-done step-active"><a href="javascript:void(0)">Complete</a></li>
                                </ol>
                            </div>

                            <!-- Checkout completion message and actions -->
                            <div class="payment-methods mt-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="checkout-completion text-center">
                                            <div class="completion-icon mb-4">
                                                <!-- Replace with your completion icon/image -->
                                                <i class="fas fa-check-circle fa-5x text-success"></i>
                                            </div>
                                            <h3 class="mb-3">Thank You!</h3>
                                            <h4>Your Order Has Been Placed</h4>
                                            <p class="mb-4">We appreciate your business. Your order has been successfully placed.</p>
                                            <p><strong>Order ID:</strong> #{{ $order_id }}</p>
                                            <p>An email confirmation has been sent to your email address.</p>

                                            <a href="{{ route('shop.index') }}" class="btn btn-primary mt-4">Continue Shopping</a>
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
