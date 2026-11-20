@extends('ecom.admin.layouts.app')

@section('style')
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

        div,
        p,
        a,
        li,
        td {
            -webkit-text-size-adjust: none;
        }

        .ReadMsgBody {
            width: 100%;
            background-color: #ffffff;
        }

        .ExternalClass {
            width: 100%;
            background-color: #ffffff;
        }

        body {
            width: 100%;
            height: 100%;
            background-color: #e1e1e1;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        html {
            width: 100%;
        }

        p {
            padding: 0 !important;
            margin-top: 0 !important;
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            margin-left: 0 !important;
        }

        .visibleMobile {
            display: none;
        }

        .hiddenMobile {
            display: block;
        }

        @media only screen and (max-width: 600px) {
            body {
                width: auto !important;
            }

            table[class=fullTable] {
                width: 96% !important;
                clear: both;
            }

            table[class=fullPadding] {
                width: 85% !important;
                clear: both;
            }

            table[class=col] {
                width: 45% !important;
            }

            .erase {
                display: none;
            }
        }

        @media only screen and (max-width: 420px) {
            table[class=fullTable] {
                width: 100% !important;
                clear: both;
            }

            table[class=fullPadding] {
                width: 85% !important;
                clear: both;
            }

            table[class=col] {
                width: 100% !important;
                clear: both;
            }

            table[class=col] td {
                text-align: left !important;
            }

            .erase {
                display: none;
                font-size: 0;
                max-height: 0;
                line-height: 0;
                padding: 0;
            }

            .visibleMobile {
                display: block !important;
            }

            .hiddenMobile {
                display: none !important;
            }
        }
    </style>
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

        div,
        p,
        a,
        li,
        td {
            -webkit-text-size-adjust: none;
        }

        .ReadMsgBody {
            width: 100%;
            background-color: #ffffff;
        }

        .ExternalClass {
            width: 100%;
            background-color: #ffffff;
        }

        p {
            padding: 0 !important;
            margin-top: 0 !important;
            margin-right: 0 !important;
            margin-bottom: 0 !important;
            margin-left: 0 !important;
        }

        .visibleMobile {
            display: none;
        }

        .hiddenMobile {
            display: block;
        }

        @media only screen and (max-width: 600px) {
            body {
                width: auto !important;
            }

            table[class=fullTable] {
                width: 96% !important;
                clear: both;
            }

            table[class=fullPadding] {
                width: 85% !important;
                clear: both;
            }

            table[class=col] {
                width: 45% !important;
            }

            .erase {
                display: none;
            }
        }

        @media only screen and (max-width: 420px) {
            table[class=fullTable] {
                width: 100% !important;
                clear: both;
            }

            table[class=fullPadding] {
                width: 85% !important;
                clear: both;
            }

            table[class=col] {
                width: 100% !important;
                clear: both;
            }

            table[class=col] td {
                text-align: left !important;
            }

            .erase {
                display: none;
                font-size: 0;
                max-height: 0;
                line-height: 0;
                padding: 0;
            }

            .visibleMobile {
                display: block !important;
            }

            .hiddenMobile {
                display: none !important;
            }
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
        <div class="row">
            <div class="col-6">
                <h5 class="card-title">{{ $title }}</h5>
            </div>
            <div class="col-6">
                <a href="" class="btn btn-primary float-end mt-3"
                    id="print">
                    Print <i class="bi bi-printer"></i>
                </a>
            </div>
        </div>

        <div id="invoice_container">
            <!-- Header -->
            <table width="100%" border="0" cellpadding="0"
                cellspacing="0" align="center" class="fullTable"
                bgcolor="#e1e1e1">
                <tr>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td>
                        <table width="800" border="0" cellpadding="0"
                            cellspacing="0" align="center" class="fullTable"
                            bgcolor="#ffffff"
                            style="border-radius: 10px 10px 0 0;">
                            <tr class="hiddenMobile">
                                <td height="40"></td>
                            </tr>
                            <tr class="visibleMobile">
                                <td height="30"></td>
                            </tr>

                            <tr>
                                <td>
                                    <table width="600" border="0"
                                        cellpadding="0" cellspacing="0"
                                        align="center" class="fullPadding">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table width="220"
                                                        border="0"
                                                        cellpadding="0"
                                                        cellspacing="0"
                                                        align="left"
                                                        class="col">
                                                        <tbody>
                                                            <tr>
                                                                <td
                                                                    align="left">
                                                                    <img src="{{ asset('logos/ecom.png') }}"
                                                                        alt="Shrivenu"
                                                                        title="Shrivenu"
                                                                        class="img-fluid m-auto"
                                                                        id="big_screen"
                                                                        width="150px"
                                                                        height="40px">
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="hiddenMobile">
                                                                <td
                                                                    height="20">
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="visibleMobile">
                                                                <td
                                                                    height="20">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    Hello,
                                                                    {{ ucfirst($order->customer->name) }}
                                                                    {{ $order->customer->last_name }}
                                                                    <br>
                                                                    Thank
                                                                    you
                                                                    for
                                                                    shopping
                                                                    from
                                                                    our
                                                                    website
                                                                    and
                                                                    for
                                                                    your
                                                                    order.
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table width="220"
                                                        border="0"
                                                        cellpadding="0"
                                                        cellspacing="0"
                                                        align="right"
                                                        class="col">
                                                        <tbody>
                                                            <tr
                                                                class="visibleMobile">
                                                                <td
                                                                    height="20">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    height="5">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    style="font-size: 21px; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;">
                                                                    Invoice
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                            <tr
                                                                class="hiddenMobile">
                                                                <td
                                                                    height="50">
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="visibleMobile">
                                                                <td
                                                                    height="20">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                                                                    <small>ORDER</small>
                                                                    {{ $order->order_number }}<br />
                                                                    <small>{{ $order->created_at->format('M d, Y') }}</small>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- /Header -->
            <!-- Order Details -->
            <table width="100%" border="0" cellpadding="0"
                cellspacing="0" align="center" class="fullTable"
                bgcolor="#e1e1e1">
                <tbody>
                    <tr>
                        <td>
                            <table width="800" border="0"
                                cellpadding="0" cellspacing="0" align="center"
                                class="fullTable" bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                    <tr class="hiddenMobile">
                                        <td height="60"></td>
                                    </tr>
                                    <tr class="visibleMobile">
                                        <td height="40"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="600"
                                                border="0" cellpadding="0"
                                                cellspacing="0" align="center"
                                                class="fullPadding">
                                                <tbody>
                                                    <tr>
                                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;"
                                                            width="52%"
                                                            align="left">
                                                            Product
                                                        </th>
                                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                            align="left">
                                                            <small>Price</small>
                                                        </th>
                                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                            align="center">
                                                            Quantity
                                                        </th>
                                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                            align="right">
                                                            Subtotal
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td height="1"
                                                            style="background: #bebebe;"
                                                            colspan="4">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="10"
                                                            colspan="4">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        @foreach ($order->orderItems as $item)

                                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                            class="article">
                                                            {{ $item->product->name }}
                                                        </td>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;">
                                                            <small>₹{{ $item->price }}</small>
                                                        </td>
                                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                            align="center">
                                                            {{ $item->quantity }}</td>
                                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                            align="right">
                                                            ₹{{ $item->price * $item->quantity }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="1"
                                                            colspan="4"
                                                            style="border-bottom:1px solid #e4e4e4">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- /Order Details -->
            <!-- Total -->
            <table width="100%" border="0" cellpadding="0"
                cellspacing="0" align="center" class="fullTable"
                bgcolor="#e1e1e1">
                <tbody>
                    <tr>
                        <td>
                            <table width="800" border="0"
                                cellpadding="0" cellspacing="0"
                                align="center" class="fullTable"
                                bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                        <td>

                                            <!-- Table Total -->
                                            <table width="600"
                                                border="0"
                                                cellpadding="0"
                                                cellspacing="0"
                                                align="center"
                                                class="fullPadding">
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            Subtotal
                                                        </td>
                                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                                            width="80">
                                                            ₹{{ $order->subtotal }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            Shipping
                                                            &amp;
                                                            Handling
                                                        </td>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            ₹{{ $order->shipping }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            <strong>Grand
                                                                Total
                                                                (Incl.Tax)</strong>
                                                        </td>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            <strong>₹{{ $order->total }}</strong>
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #b0b0b0; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            <small>TAX</small>
                                                        </td>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #b0b0b0; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            <small>$72.40</small>
                                                        </td>
                                                    </tr> --}}
                                                </tbody>
                                            </table>
                                            <!-- /Table Total -->

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- /Total -->
            <!-- Information -->
            <table width="100%" border="0" cellpadding="0"
                cellspacing="0" align="center" class="fullTable"
                bgcolor="#e1e1e1">
                <tbody>
                    <tr>
                        <td>
                            <table width="800" border="0"
                                cellpadding="0" cellspacing="0"
                                align="center" class="fullTable"
                                bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                    <tr class="hiddenMobile">
                                        <td height="60"></td>
                                    </tr>
                                    <tr class="visibleMobile">
                                        <td height="40"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="600"
                                                border="0"
                                                cellpadding="0"
                                                cellspacing="0"
                                                align="center"
                                                class="fullPadding">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table
                                                                width="220"
                                                                border="0"
                                                                cellpadding="0"
                                                                cellspacing="0"
                                                                align="left"
                                                                class="col">

                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                                            <strong>BILLING
                                                                                INFORMATION</strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="100%"
                                                                            height="10">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                                            {{-- Philip
                                                                            Brooks<br>
                                                                            Public
                                                                            Wales,
                                                                            Somewhere<br>
                                                                            New
                                                                            York
                                                                            NY<br>
                                                                            4468,
                                                                            United
                                                                            States<br>
                                                                            T:
                                                                            202-555-0133 --}}
                                                                            {{ ucfirst($order->billingAddress->first_name) }} {{ucfirst($order->billingAddress->last_name)}}<br>
                                                                            {{ $order->billingAddress->address }}<br>
                                                                            {{ $order->billingAddress->city }}<br>
                                                                            {{ $order->billingAddress->state->name }}, {{ $order->billingAddress->zip }}<br>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>


                                                            <table
                                                                width="220"
                                                                border="0"
                                                                cellpadding="0"
                                                                cellspacing="0"
                                                                align="right"
                                                                class="col">
                                                                <tbody>
                                                                    <tr
                                                                        class="visibleMobile">
                                                                        <td
                                                                            height="20">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                                            <strong>PAYMENT
                                                                                METHOD</strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="100%"
                                                                            height="10">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                                            {{-- Credit
                                                                            Card<br>
                                                                            Credit
                                                                            Card
                                                                            Type:
                                                                            Visa<br>
                                                                            Worldpay
                                                                            Transaction
                                                                            ID:
                                                                            <a href="#"
                                                                                style="color: #3bbe5c; text-decoration:underline;">4185939336</a><br>
                                                                            <a href="#"
                                                                                style="color:#b0b0b0;">Right
                                                                                of
                                                                                Withdrawal</a> --}}

                                                                            {{ $order->payment_method }}<br>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="600"
                                                border="0"
                                                cellpadding="0"
                                                cellspacing="0"
                                                align="center"
                                                class="fullPadding">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table
                                                                width="220"
                                                                border="0"
                                                                cellpadding="0"
                                                                cellspacing="0"
                                                                align="left"
                                                                class="col">
                                                                <tbody>
                                                                    <tr
                                                                        class="hiddenMobile">
                                                                        <td
                                                                            height="35">
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="visibleMobile">
                                                                        <td
                                                                            height="20">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                                            <strong>SHIPPING
                                                                                INFORMATION</strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="100%"
                                                                            height="10">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                                            {{-- Sup
                                                                            Inc<br>
                                                                            Another
                                                                            Place,
                                                                            Somewhere<br>
                                                                            New
                                                                            York
                                                                            NY<br>
                                                                            4468,
                                                                            United
                                                                            States<br>
                                                                            T:
                                                                            202-555-0171 --}}
                                                                            {{ ucfirst($order->shippingAddress->first_name) }} {{ucfirst($order->shippingAddress->last_name)}}<br>
                                                                            {{ $order->shippingAddress->address }}<br>
                                                                            {{ $order->shippingAddress->city }}<br>
                                                                            {{ $order->shippingAddress->state->name }}, {{ $order->shippingAddress->zip }}<br>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>


                                                            <table
                                                                width="220"
                                                                border="0"
                                                                cellpadding="0"
                                                                cellspacing="0"
                                                                align="right"
                                                                class="col">
                                                                <tbody>
                                                                    <tr
                                                                        class="hiddenMobile">
                                                                        <td
                                                                            height="35">
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="visibleMobile">
                                                                        <td
                                                                            height="20">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                                            <strong>SHIPPING
                                                                                METHOD</strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="100%"
                                                                            height="10">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                                            {{-- UPS:
                                                                            U.S.
                                                                            Shipping
                                                                            Services --}}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class="hiddenMobile">
                                        <td height="60"></td>
                                    </tr>
                                    <tr class="visibleMobile">
                                        <td height="30"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- /Information -->
            <table width="100%" border="0" cellpadding="0"
                cellspacing="0" align="center" class="fullTable"
                bgcolor="#e1e1e1">

                <tr>
                    <td>
                        <table width="800" border="0" cellpadding="0"
                            cellspacing="0" align="center" class="fullTable"
                            bgcolor="#ffffff"
                            style="border-radius: 0 0 10px 10px;">
                            <tr>
                                <td>
                                    <table width="600" border="0"
                                        cellpadding="0" cellspacing="0"
                                        align="center" class="fullPadding">
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                    Have a nice
                                                    day.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr class="spacer">
                                <td height="50"></td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="20"></td>
                </tr>
            </table>
        </div>

    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });

            $('#print').on('click', function() {
                var printContents = document.getElementById(
                    'invoice_container').innerHTML;
                var originalContents = document.body.innerHTML;

                // Open a new window with the invoice content
                var popupWin = window.open('', '_blank');
                popupWin.document.open();
                popupWin.document.write(
                    '<html><head><title>Print Invoice</title></head><body>' +
                    printContents + '</body></html>');
                popupWin.document.close();

                // Wait for the new window to finish loading before printing
                popupWin.onload = function() {
                    popupWin.focus();
                    popupWin.print();
                    popupWin.close();
                };

                // Restore the original content after printing
                document.body.innerHTML = originalContents;
            });


        });
    </script>
@endsection
