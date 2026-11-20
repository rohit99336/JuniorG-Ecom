@extends('admin.layouts.app')


@section('content')
    <section class="section">
        <div class="pagetitle">
            <h1>{{ $title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('ecomadmin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $subTitle }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        {{-- <div class="container mt-5">
        <h2>Contact Us</h2>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
            </div> --}}

        <div class="card p-5">
            <h2>Contact Details</h2>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $contactus->name }}</p>
                    <p><strong>Email:</strong> {{ $contactus->email }}</p>
                    <p><strong>Phone:</strong> {{ $contactus->mobile_no }}</p>
                    <p><strong>Message:</strong> </p>
                    <p>{{ $contactus->message }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <!-- Add Bootstrap JS and Popper.js Links -->
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta2/js/bootstrap.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
@endsection
