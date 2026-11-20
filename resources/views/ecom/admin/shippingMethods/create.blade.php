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
        <div class="row">
            <div class="col-lg-12">
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

                        <form class="row g-3 needs-validation" action="{{ route('ecomadmin.setting.shipping-methods.store') }}" method="POST"
                            novalidate>
                            @csrf

                            <div class="col-md-6">
                                <label for="title" class="form-label">Shipping method</label>
                                <input type="text" class="form-control" id="title" name="name"
                                    value="{{ old('name') }}" required>
                                <div class="invalid-feedback">
                                    Please enter shipping method.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="delivery_time" class="form-label">Delivery time</label>
                                <input type="text" class="form-control" id="delivery_time" name="delivery_time"
                                    value="{{ old('delivery_time') }}" required>
                                <div class="invalid-feedback">
                                    Please enter delivery time.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="delivery_charge" class="col-form-label">
                                    Delivery charge
                                </label>
                                <input type="text" class="form-control" id="delivery_charge" name="delivery_charge"
                                    value="{{ old('delivery_charge') }}" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="10" maxlength="10">
                                <div class="invalid-feedback">
                                    Please enter Delivery charge.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="03" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter shipping method description.
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
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/filemanager.js') }}"></script>
    <script>
        $(document).ready(function() {
            // close alert automatically after 3 seconds
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });

            $('#lfm').filemanager('file');

            // Listen for changes in the "thumbnail" input field
            $('#thumbnail').change(function() {
                var imageUrl = $(this).val();
                $('#holder').attr('src', imageUrl);
            });
        });
    </script>
@endsection
