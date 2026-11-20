@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/my.css') }}">
@endsection

@section('content')
    @php
        $color = '';
        if ($enquiry->status == 'new') {
            $color = 'text-info';
        } elseif ($enquiry->status == 'completed') {
            $color = 'text-success';
        } elseif ($enquiry->status == 'in progress') {
            $color = 'text-primary';
        }
    @endphp

    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('ecomadmin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div>

    <section>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="top-status">
                        <h5 class="mt-3">Enquiry No.# 0{{ $enquiry->id }}</h5>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5>Client Detail</h5>
                                <table>
                                    <tr>
                                        <td>
                                            <span class="fw-normal">Name : </span>
                                            {{ ucfirst($enquiry->name) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="fw-normal">Mobile : </span>
                                            <a href="tel:+91{{ $enquiry->mobile_no }}"
                                                class="text-dark">{{ $enquiry->mobile_no }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="fw-normal">Email : </span>
                                            <a href="mailto:{{ $enquiry->email }}"
                                                class="text-dark">{{ $enquiry->email }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="fw-normal">Address : </span>
                                            {{ $enquiry->address }}
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Appoinment Detail</h5>
                                <table>
                                    <tr>
                                        <td>
                                            <span class="fw-normal">Enquiry Date : </span>
                                            {{ date('d/m/Y', strtotime($enquiry->date)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="fw-normal">Enquiry Time : </span>
                                            {{ date('h:i A', strtotime($enquiry->created_at)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="fw-normal">Course : </span>
                                            {{ ucfirst($enquiry->course->name) }}
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
                    <h4 class="p-3 mb-0">Course Description</h4>
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Fee</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{ ucfirst($enquiry->name) }}
                                </td>
                                <td>
                                    <strong>
                                        ₹{{ $enquiry->course->price }}
                                    </strong>
                                </td>
                                <td>
                                    <strong>
                                        {{ $enquiry->course->description }}
                                    </strong>
                                </td>
                                <td class="text-center">
                                    <select class="form-select fs-6" id="enq_status" name="enq_status">
                                        <option value="new" {{ $enquiry->status == 'new' ? 'selected' : '' }}>
                                            New</option>
                                        <option value="in progress"
                                            {{ $enquiry->status == 'in progress' ? 'selected' : '' }}>
                                            In progress</option>
                                        <option value="completed" {{ $enquiry->status == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- Footer area -->
                            <tr>
                                <th colspan="2">
                                    <span>Status:</span>
                                    <span class="badge badge-success {{ $color }}">
                                        {{ ucfirst($enquiry->status) }}
                                    </span>
                                </th>
                                <td>
                                    <span class="text-muted">Total Price</span>
                                    <strong>
                                        ₹{{ $enquiry->course->price }}
                                    </strong>
                                </td>
                                {{-- <td>
                                    <span class="text-muted">Total Paid</span>
                                    @if ($enquiry->enquiriesService->payment_status == 'pending' || $enquiry->enquiriesService->payment_status == 'failed')
                                        <strong>
                                            ₹0
                                        </strong>
                                    @else
                                        <strong>
                                            ₹{{ $enquiry->enquiriesService->price }}
                                        </strong>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">Due</span>
                                    @if ($enquiry->enquiriesService->payment_status == 'pending')
                                        <strong>
                                            ₹{{ $enquiry->enquiriesService->price }}
                                        </strong>
                                    @else
                                        <strong>
                                            ₹0
                                        </strong>
                                    @endif
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // change payment status using ajax
            $('#enq_status').change(function() {
                var enq_status = $(this).val();
                var enquiry_id = {{ $enquiry->id }};
                $.ajax({
                    url: "{{ route('change-course-status') }}",
                    type: "POST",
                    data: {
                        status: enq_status,
                        id: enquiry_id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.message) {
                            alert(response.message);
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
