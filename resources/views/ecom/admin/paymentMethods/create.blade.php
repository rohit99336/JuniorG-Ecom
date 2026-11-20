@extends('ecom.admin.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('ecomadmin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $subTitle }}</h5>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                            aria-label="Close">
                            {{-- <span aria-hidden="true">&times;</span> --}}
                        </button>

                        <strong>Error!</strong> Please fix the following issues:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="row g-3 needs-validation" action="{{ route('ecomadmin.setting.payment-methods.store') }}"
                    method="POST" novalidate>
                    @csrf

                    <div class="col-md-6">
                        <label for="title" class="form-label">Payment method</label>
                        <input type="text" class="form-control" id="title" name="name" value="{{ old('name') }}"
                            required>
                        <div class="invalid-feedback">
                            Please enter payment method.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="03" required></textarea>
                        <div class="invalid-feedback">
                            Please enter payment method description.
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary float-end" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // close alert automatically after 3 seconds
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>
@endsection
