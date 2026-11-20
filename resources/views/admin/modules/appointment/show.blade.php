@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/my.css') }}">
@endsection

@section('content')
    @php
        $color = '';
        if ($appointment->appointmentService->payment_status == 'pending') {
            $color = 'text-warning';
        } elseif ($appointment->appointmentService->payment_status == 'paid') {
            $color = 'text-success';
        } elseif ($appointment->appointmentService->payment_status == 'failed') {
            $color = 'text-danger';
        } elseif ($appointment->appointmentService->payment_status == 'completed') {
            $color = 'text-primary';
        }
    @endphp
    <section class="my-5">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="top-status">
                                    <h5 class="mt-3">Appointment# 0{{ $appointment->id }}</h5>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h5>Client Detail</h5>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <span class="fw-normal">Name : </span>
                                                        {{ ucfirst($appointment->name) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="fw-normal">Mobile : </span>
                                                        <a href="tel:+91{{ $appointment->phone }}"
                                                            class="text-dark">{{ $appointment->phone }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="fw-normal">Email : </span>
                                                        <a href="mailto:{{ $appointment->email }}"
                                                            class="text-dark">{{ $appointment->email }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="fw-normal">Address : </span>
                                                        {{ $appointment->address }}
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Appoinment Detail</h5>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <span class="fw-normal">Appointment Date : </span>
                                                        {{ date('d/m/Y', strtotime($appointment->date)) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="fw-normal">Appointment Time : </span>
                                                        {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="fw-normal">Salon : </span>
                                                        {{ ucfirst($appointment->salon->name) }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-body p-0 table-responsive">
                                <h4 class="p-3 mb-0">Service Description</h4>
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Description</th>
                                            <th scope="col">Service</th>
                                            {{-- <th scope="col">Quantity</th> --}}
                                            <th scope="col">Amount</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Payment status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                <img src="{{ $appointment->service->image }}" alt="Service" class=""
                                                    width="80">
                                            </th>
                                            <td>
                                                {{ $appointment->appointmentService->serviceVariant->name }}
                                            </td>
                                            {{-- <td>$100 X 2</td> --}}
                                            <td>
                                                <strong>
                                                    ₹{{ $appointment->appointmentService->price }}
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning {{ $color }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <select class="form-select fs-6" id="paymentStatus" name="paymentStatus">
                                                    <option value="pending"
                                                        {{ $appointment->appointmentService->payment_status == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="paid"
                                                        {{ $appointment->appointmentService->payment_status == 'paid' ? 'selected' : '' }}>
                                                        Paid</option>
                                                    <option value="failed"
                                                        {{ $appointment->appointmentService->payment_status == 'failed' ? 'selected' : '' }}>
                                                        Failed</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <!-- Footer area -->
                                        <tr>
                                            <th colspan="2">
                                                <span>Status:</span>
                                                <span class="badge badge-success {{ $color }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </th>
                                            <td>
                                                <span class="text-muted">Total Price</span>
                                                <strong>
                                                    ₹{{ $appointment->appointmentService->price }}
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">Total Paid</span>
                                                @if (
                                                    $appointment->appointmentService->payment_status == 'pending' ||
                                                        $appointment->appointmentService->payment_status == 'failed')
                                                    <strong>
                                                        ₹0
                                                    </strong>
                                                @else
                                                    <strong>
                                                        ₹{{ $appointment->appointmentService->price }}
                                                    </strong>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-muted">Due</span>
                                                @if ($appointment->appointmentService->payment_status == 'pending')
                                                    <strong>
                                                        ₹{{ $appointment->appointmentService->price }}
                                                    </strong>
                                                @else
                                                    <strong>
                                                        ₹0
                                                    </strong>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="card mt-4">
                            <div class="card-body">
                                <h4>Timeline</h4>
                                <ul class="timeline">
                                    <li class="active">
                                        <h6>PICKED</h6>
                                        <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            Quisque Lorem ipsum dolor</p>
                                        <o class="text-muted">21 March, 2014</p>
                                    </li>
                                    <li>
                                        <h6>PICKED</h6>
                                        <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            Quisque</p>
                                        <o class="text-muted">21 March, 2014</p>
                                    </li>
                                    <li>
                                        <h6>PICKED</h6>
                                        <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            Quisque</p>
                                        <o class="text-muted">21 March, 2014</p>
                                    </li>
                                    <li>
                                        <h6>PICKED</h6>
                                        <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            Quisque</p>
                                        <o class="text-muted">21 March, 2014</p>
                                    </li>
                                    <li>
                                        <h6>PICKED</h6>
                                        <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                            Quisque</p>
                                        <o class="text-muted">21 March, 2014</p>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // change payment status using ajax
            $('#paymentStatus').change(function() {
                var paymentStatus = $(this).val();
                var appointmentId = {{ $appointment->id }};
                $.ajax({
                    url: "{{ route('change-payment-status') }}",
                    type: "POST",
                    data: {
                        paymentStatus: paymentStatus,
                        appointmentId: appointmentId,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.msg) {
                            alert(response.msg);
                            location.reload();
                        } else {
                            alert(response.error);
                        }
                    }
                });
            });
        });
    </script>
@endsection
