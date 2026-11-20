@extends('ecom.web.layouts.app')

@section('meta')
    <title>Shrivenu Naturals - Order Detail</title>
@endsection

@section('styles')
@endsection

@section('content')
    @include('ecom.web.layouts.bradcamp')

    <main id="MainContent" class="content-for-layout mt-5">
        <div class="container">
            <h3 class="cart-page-title">Order Details</h3>

            <div class="row">
                <div class="col-lg-8 mb-3">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Items from Order
                                #{{ $order->id }}</h4>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td>{{ $item->productVariant->product->name }}
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>₹{{ $item->productVariant->price }}
                                                </td>
                                                <td>₹{{ $item->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-4 mb-3">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Order Summary</h4>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Grand Total :</td>
                                            <td>₹{{ $order->subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Charge :</td>
                                            <td>₹{{ $order->shipping }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total :</strong></td>
                                            <td><strong>₹{{ $order->total }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Shipping Information
                            </h4>
                            <h6>{{ ucfirst($order->shippingAddress->first_name) }}
                                {{ $order->shippingAddress->last_name }}</h6>
                            <address class="mb-0 font-14">
                                {{ $order->shippingAddress->address }}<br>
                                {{ $order->shippingAddress->city }},
                                {{ $order->shippingAddress->state->name }},
                                {{ $order->shippingAddress->zip }}<br>
                                <abbr title="Phone">Phone:</abbr>
                                {{ $order->shippingAddress->phone }}
                            </address>
                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-4">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="header-title mb-3">
                                Billing Information
                            </h4>
                            <h6>{{ ucfirst($order->billingAddress->first_name) }}
                                {{ $order->billingAddress->last_name }}</h6>
                            <address class="mb-0 font-14">
                                {{ $order->billingAddress->address }}<br>
                                {{ $order->billingAddress->city }},
                                {{ $order->billingAddress->state->name }},
                                {{ $order->billingAddress->zip }}<br>
                                <abbr title="Phone">Phone:</abbr>
                                {{ $order->billingAddress->phone }}
                            </address>
                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-4">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h4 class="header-title text-center mb-3">Delivery Info</h4>
                            <div class="text-center">
                                <i class="bi bi-truck h2 text-muted"></i>
                                <p class="mb-1"><strong>Order ID :</strong>
                                    {{ $order->order_number }}</p>
                                <p class="mb-1"><strong>Order Date :</strong>
                                    {{ date('d/m/Y', strtotime($order->created_at)) }}
                                </p>
                                <p class="mb-0"><strong>Payment Mode
                                        :</strong>
                                    {{ $order->payment_method }}</p>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
