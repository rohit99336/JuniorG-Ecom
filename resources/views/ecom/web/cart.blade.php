@extends('ecom.web.layouts.app')

@section('meta')
    <title>Junior-G Cart: Natural Baby Products - Shop Online</title>

    <meta name="description"
        content="Explore a wide range of natural baby products by Junior-G. Shop online for eco-friendly diapers, skincare, and more. Conveniently add items to your cart for quick checkout.">

    <meta name="keywords"
        content="Junior-G, natural baby products, eco-friendly diapers, baby skincare, baby essentials, online shopping, cart, checkout">
@endsection

@section('styles')
@endsection

@section('content')
    @php
        $cartCount = 0;
        if (session()->has('cart')) {
            $cartCount = count(session()->get('cart'));
        }

        // get cart data from session
        $cartData = session()->get('cart');
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
        }else {
            $grandTotal = 0;
            $shippingCharge = 0;
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
        <div class="cart-page mt-100">
            <div class="container">
                <div class="cart-page-wrapper">
                    <div class="row">
                        <div class="col-lg-7 col-md-12 col-12">
                            @if (!empty($cartData) && count($cartData) > 0)
                                <table class="cart-table w-100">
                                    <thead>
                                        <tr>
                                            <th
                                                class="cart-caption heading_18">
                                                Product</th>
                                            <th
                                                class="cart-caption heading_18">
                                            </th>
                                            <th
                                                class="cart-caption text-center heading_18 d-none d-md-table-cell">
                                                Quantity</th>
                                            <th
                                                class="cart-caption text-end heading_18">
                                                Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartData as $key => $item)
                                            <tr class="cart-item">
                                                <td class="cart-item-media">
                                                    <div
                                                        class="mini-img-wrapper">
                                                        <img class="mini-img"
                                                            src="{{ $item['image'] }}"
                                                            alt="{{ $item['name'] }}">
                                                    </div>
                                                </td>
                                                <td class="cart-item-details">
                                                    <h2 class="product-title">
                                                        <a href="#">
                                                            {{ ucfirst($item['name']) }}</a>
                                                    </h2>
                                                    <p class="product-vendor">
                                                        {{ ucfirst($item['product_category']) }}
                                                    </p>
                                                </td>
                                                <td class="cart-item-quantity">
                                                    <div
                                                        class="quantity d-flex align-items-center justify-content-between">
                                                        <button
                                                            class="qty-btn dec-qty"
                                                            data-sessionkey="{{ $key }}"
                                                            data-product_variant_id="{{ $item['product_variant_id'] }}">
                                                            <img src="{{ asset('ecom/web/assets/img/icon/minus.svg') }}"
                                                                alt="minus">
                                                        </button>
                                                        <input
                                                            class="qty-input"
                                                            type="number"
                                                            name="qty"
                                                            value="{{ $item['quantity'] }}"
                                                            min="0">
                                                        <button
                                                            class="qty-btn inc-qty"
                                                            data-sessionkey="{{ $key }}"
                                                            data-product_variant_id="{{ $item['product_variant_id'] }}">
                                                            <img src="{{ asset('ecom/web/assets/img/icon/plus.svg') }}"
                                                                alt="plus">
                                                        </button>
                                                    </div>
                                                    <a href="{{ route('cart.remove', $item['product_variant_id']) }}"
                                                        class="product-remove mt-2">Remove</a>
                                                </td>
                                                <td
                                                    class="cart-item-price text-end">
                                                    <div class="product-price">
                                                        ₹{{ $item['price'] }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="empty-cart-message">
                                    <div class="row mt-100">
                                        <div
                                            class="col-12 m-auto text-center justify-content-center">
                                            <p>Your cart is empty.</p>
                                            <p>Add new products to continue
                                                shopping.</p>
                                            <a href="{{ route('shop.products') }}"
                                                class="btn btn-primary">Shop
                                                Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-5 col-md-12 col-12">
                            <div class="cart-total-area">
                                <h3
                                    class="cart-total-title d-none d-lg-block mb-0">
                                    Cart Totals</h4>
                                    <div class="cart-total-box mt-4">
                                        <div
                                            class="subtotal-item subtotal-box">
                                            <h4 class="subtotal-title">
                                                Subtotals:</h4>
                                            <p class="subtotal-value">
                                                ₹{{ $total }}
                                            </p>
                                        </div>
                                        <div
                                            class="subtotal-item shipping-box">
                                            <h4 class="subtotal-title">
                                                Shipping:</h4>
                                            <p class="subtotal-value">
                                                {{ count($cartData) > 0 ? '₹' . $shippingCharge : '₹0' }}
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
                                        <div
                                            class="subtotal-item discount-box">
                                            <h4 class="subtotal-title">Total:
                                            </h4>
                                            <p class="subtotal-value">
                                                ₹{{ $grandTotal }}
                                            </p>
                                        </div>
                                        <p class="shipping_text">Shipping &
                                            taxes calculated at checkout</p>

                                        @if (!empty($cartData) && count($cartData) > 0)
                                            <div
                                                class="d-flex justify-content-center mt-4">
                                                <a href="{{ route('shop.checkout') }}"
                                                    class="position-relative btn-primary text-uppercase">
                                                    Procced to checkout
                                                </a>
                                            </div>
                                        @else
                                            <div
                                                class="d-flex justify-content-center mt-4">
                                                <a href="{{ route('shop.products') }}"
                                                    class="position-relative btn-primary text-uppercase">
                                                    Continue to shopping
                                                </a>
                                            </div>
                                        @endif
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
            $('#short_by').on('change', function() {
                var short_by = $(this).val();
                var url = "{{ route('shop.products') }}";
                if (short_by) {
                    url = url + '?' + short_by;
                }
                window.location.href = url;
            });
        });

        /*--
        Update cart
        -----------------------------------*/
        function changeCartQuantity(sessionkey, variant_id, qty) {
            var baseUrl = "cart/update";
            var url = baseUrl + '/' + sessionkey;
            var token = $('meta[name="csrf-token"]').attr('content');
            // Display loading GIF
            $('#loading').show();

            console.log(sessionkey, variant_id, qty);

            // $.ajax({
            //     url: url,
            //     method: 'PUT',
            //     data: {
            //         quantity: qty,
            //         product_variant_id: variant_id,
            //         sessionkey: sessionkey,
            //         _token: token
            //     },
            //     success: function(data) {
            //         // Hide loading GIF
            //         $('#loading').hide();
            //         console.log(data.status);
            //         // Reload page on successful response
            //         if (data.status === 'success') {
            //             location.reload();
            //         }
            //     },
            //     error: function() {
            //         // Hide loading GIF on error
            //         $('#loading').hide();
            //     }
            // });
        }
    </script>
@endsection
