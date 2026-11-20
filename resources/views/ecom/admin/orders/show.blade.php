@extends('ecom.admin.layouts.app')

@section('style')
    <style>
        #progressbar {
            margin-bottom: 3vh;
            overflow: hidden;
            color: rgb(27, 187, 62);
            padding-left: 0px;
            margin-top: 3vh
        }

        #progressbar li {
            list-style-type: none;
            font-size: x-small;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400;
            color: rgb(160, 159, 159);
        }

        #progressbar #step1:before {
            content: "";
            color: rgb(27, 187, 62);
            width: 5px;
            height: 5px;
            margin-left: 0px !important;
            /* padding-left: 11px !important */
        }

        #progressbar #step2:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-left: 32%;
        }

        #progressbar #step3:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 32%;
            /* padding-right: 11px !important */
        }

        #progressbar #step4:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 0px !important;
            /* padding-right: 11px !important */
        }

        #progressbar li:before {
            line-height: 29px;
            display: block;
            font-size: 12px;
            background: #ddd;
            border-radius: 50%;
            margin: auto;
            z-index: -1;
            margin-bottom: 1vh;
        }

        #progressbar li:after {
            content: '';
            height: 2px;
            background: #ddd;
            position: absolute;
            left: 0%;
            right: 0%;
            margin-bottom: 2vh;
            top: 1px;
            z-index: 1;
        }

        .progress-track {
            padding: 0 8%;
        }

        #progressbar li:nth-child(2):after {
            margin-right: auto;
        }

        #progressbar li:nth-child(1):after {
            margin: auto;
        }

        #progressbar li:nth-child(3):after {
            float: left;
            width: 68%;
        }

        #progressbar li:nth-child(4):after {
            margin-left: auto;
            width: 132%;
        }

        #progressbar li.active {
            color: black;
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: rgb(27, 187, 62);
        }

        .title {
            color: rgb(27, 187, 62);
            font-weight: 600;
            margin-bottom: 2vh;
            padding: 0 8%;
            font-size: initial;
        }
    </style>
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
                </a> 'pending','processing','completed','declined','refunded','cancelled','failed' --}}

                <div class="dropdown float-end mt-3">
                    <label for="">Status</label>
                    <a class="btn btn-info dropdown-toggle"
                        href="JavaScript:void(0);" role="button"
                        id="dropdownStatus" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ $order->status }}
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownStatus">
                        <li>

                            @foreach ($orderStatusOptions as $ordstatus)
                                <a class="dropdown-item"
                                    href="JavaScript:void(0);"
                                    data-id="{{ $order->id }}"
                                    data-status="{{ $ordstatus }}"
                                    {{ $ordstatus == $order->status }}>
                                    {{ ucfirst($ordstatus) }}
                                </a>
                            @endforeach
                            {{-- <a class="dropdown-item" href="JavaScript:void(0);"
                                data-id="{{ $order->id }}"
                                data-status="processing" {{ $selected }}>
                                Processing
                            </a>
                            <a class="dropdown-item" href="JavaScript:void(0);"
                                data-id="{{ $order->id }}"
                                data-status="completed" {{ $selected }}>
                                Completed
                            </a>
                            <a class="dropdown-item" href="JavaScript:void(0);"
                                data-id="{{ $order->id }}"
                                data-status="declined" {{ $selected }}>
                                Declined
                            </a>
                            <a class="dropdown-item" href="JavaScript:void(0);"
                                data-id="{{ $order->id }}"
                                data-status="refunded" {{ $selected }}>
                                Refunded
                            </a>
                            <a class="dropdown-item" href="JavaScript:void(0);"
                                data-id="{{ $order->id }}"
                                data-status="cancelled" {{ $selected }}>
                                Cancelled
                            </a>
                            <a class="dropdown-item" href="JavaScript:void(0);"
                                data-id="{{ $order->id }}"
                                data-status="failed" {{ $selected }}>
                                Failed
                            </a> --}}
                        </li>

                    </ul>
                </div>
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

        {{-- <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tracking">
                            <div class="title mt-3">Tracking Order
                            </div>
                        </div>
                        <div class="progress-track">
                            <ul id="progressbar">
                                <li class="step0 active " id="step1">
                                    Ordered</li>
                                <li class="step0 active text-center"
                                    id="step2">Shipped</li>
                                <li class="step0 active text-right"
                                    id="step3">On the way</li>
                                <li class="step0 text-right" id="step4">
                                    Delivered</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-1">Order ID:
                                    {{ $order->order_number }}</h4>
                                <div class="d-flex align-items-center">
                                    <small>Order Date:
                                        {{ $order->created_at->format('F d,Y') }}
                                        at
                                        {{ $order->created_at->format('g:i A') }}

                                    </small> <span
                                        class="badge badge-success-soft ms-2">Paid</span>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('ecomadmin.invoice', $order->id) }}"
                                    class="btn btn-sm btn-primary">Invoice</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table
                                class="table text-nowrap mb-0 table-centered">
                                <thead class="table-light">
                                    <tr>

                                        <th scope="col">Products</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Amounts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $key => $item)
                                        <tr class="align-middle">
                                            <td class="align-middle">
                                                <div
                                                    class="d-flex align-items-start justify-content-start text-center">
                                                    <a href="{{ route('shop.product', $item->productVariant->uuid) }}"
                                                        target="_blank">
                                                        <img src="{{ $item->productVariant->thumbnail_image }}"
                                                            alt="{{ $item->productVariant->name }}"
                                                            class="rounded-circle"
                                                            width="80"
                                                            height="80">
                                                    </a>
                                                    <div
                                                        class="ms-3 text-center m-auto">
                                                        <h5 class="mb-0">
                                                            <a href="{{ route('shop.product', $item->productVariant->uuid) }}"
                                                                target="_blank"
                                                                class="text-inherit">{{ $item->productVariant->product->name }}</a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="text-center align-middle">
                                                {{ $item->quantity }}</td>
                                            <td class="align-middle">
                                                ₹{{ $item->productVariant->price * $item->quantity }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Billing Address</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ ucfirst($order->billingAddress->first_name) }}
                            {{ $order->billingAddress->last_name }}</h5>

                        <address class="mb-0 font-14 address-lg">
                            {{ $order->billingAddress->address }}<br>
                            {{ $order->billingAddress->city }}<br>
                            {{ $order->billingAddress->state->name }},
                            {{ $order->billingAddress->zip }}<br>
                            <abbr title="Phone">Phone:</abbr>
                            {{ $order->billingAddress->phone }}<br />
                        </address>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Shipping Address</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ ucfirst($order->shippingAddress->first_name) }}
                            {{ $order->shippingAddress->last_name }}</h5>

                        <address class="mb-0 font-14 address-lg">
                            {{ $order->shippingAddress->address }}<br>
                            {{ $order->shippingAddress->city }}<br>
                            {{ $order->shippingAddress->state->name }},
                            {{ $order->shippingAddress->zip }}<br>
                            <abbr title="Phone">Phone:</abbr>
                            {{ $order->shippingAddress->phone }}<br />
                        </address>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mb-4 mt-4 mt-lg-0">
                    <div class="card-header">
                        <h4 class="mb-0">Order Summary</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead class="table-light">
                                <tr>

                                    <th scope="col">Descriptions</th>
                                    <th scope="col">Amounts</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td>Sub Total :</td>
                                    <td>
                                        ₹{{ $order->subtotal }}
                                    </td>

                                </tr>
                                <tr>

                                    <td>Discount : </td>
                                    <td>₹{{ $order->discount }}</td>

                                </tr>
                                <tr>

                                    <td>Shipping Charge :</td>
                                    <td>₹{{ $order->shipping }}</td>

                                </tr>
                                {{-- <tr>

                                    <td>Tax Vat 19% (included) :</td>
                                    <td>$64.00</td>

                                </tr> --}}
                                <tr>

                                    <td>Total Amount</td>
                                    <td>₹{{ $order->total }}</td>

                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Payment Details</h4>
                    </div>
                    <div class="card-body">

                        <div>
                            @foreach ($order->OrderPayments as $payment)
                                <ul class="list-unstyled mb-0">
                                    <li
                                        class="d-flex justify-content-between mb-2">
                                        <span>Transactions:
                                        </span> <span
                                            class="text-dark">#TRANS{{ $payment->id }}</span>
                                    </li>
                                    <li
                                        class="d-flex justify-content-between mb-2">
                                        <span>
                                            Payment Method:
                                        </span>
                                        <span class="text-dark">
                                            {{ $payment->payment_method }}
                                        </span>
                                    </li>
                                    <li
                                        class="d-flex justify-content-between mb-2">
                                        <span>Card Holder Name:
                                        </span>
                                        <span class="text-dark">
                                            {{ $payment->card_holder_name }}
                                        </span>
                                    </li>
                                    <li
                                        class="d-flex justify-content-between mb-2">
                                        <span>Card Number:
                                        </span>
                                        <span class="text-dark">
                                            {{ $payment->card_no }}
                                        </span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Total Amount: </span>
                                        <span
                                            class="text-dark ">₹{{ $payment->amount }}</span>
                                    </li>
                                </ul>
                            @endforeach

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

            console.log(orderId);
            console.log(newStatus);

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
