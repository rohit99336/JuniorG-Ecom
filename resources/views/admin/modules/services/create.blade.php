@extends('admin.layouts.app')


@section('content')
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('ecomadmin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New service</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

                        <form class="row g-3 needs-validation" action="{{ route('services.store') }}" method="POST"
                            novalidate>
                            @csrf
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    Service name<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" name="service_name" value=""
                                    required>

                                <div class="invalid-feedback">
                                    Please enter service name.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="gender" class="form-label">
                                    Gender<span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="service_gender" required>
                                    <option value="">Select gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select gender.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="service_description" id="description" cols="30" rows="01"></textarea>

                                <div class="invalid-feedback">
                                    Please enter salon description.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="image" class="form-label">Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-success">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="service_image" readonly>
                                </div>

                                <img id="holder" style="margin-top:15px;max-height:100px;">
                            </div>

                            <hr>

                            <div class="row">
                                <h5 class="h5 text-primary"><b>Variants</b></h5>
                                <div id="variant-container">
                                    <!-- Your initial variant input fields go here -->
                                    <div class="variant row">
                                        <div class="col-md-4">
                                            <label for="name" class="form-label">
                                                Variant name<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="name[]" value=""
                                                required>
                                            <div class="invalid-feedback">
                                                Please enter variant name.
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="price" class="form-label">
                                                Price (₹)<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="price[]" value=""
                                                required oninput="this.value = this.value.replace(/[^0-9\.]/g, '')"
                                                minlength="01" maxlength="10">
                                            <div class="invalid-feedback">
                                                Please enter price for service.
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-3">
                                            <label for="gender" class="form-label">
                                                Gender<span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" name="gender[]" required>
                                                <option value="">Select gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select gender.
                                            </div>
                                        </div> --}}
                                        <div class="col-md-2 pt-4 mt-2">
                                            <button class="btn btn-success add-variant">
                                                <i class="bx bx-plus-circle"></i>
                                            </button>
                                            <button class="btn btn-danger remove-variant">
                                                <i class="bx bx-minus-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- End of your initial variant input fields -->
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit</button>
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

    <script>
        $(document).ready(function() {
            // Function to add a new variant
            $(document).on("click", ".add-variant", function() {
                var $variantRow = $(this).closest(".variant");
                var $newVariantRow = $variantRow.clone();
                $newVariantRow.find("input, select").val(""); // Clear input values
                $newVariantRow.find('.invalid-feedback').hide(); // Hide validation messages
                $("#variant-container").append($newVariantRow);
            });

            // Function to remove a variant
            $(document).on("click", ".remove-variant", function() {
                var $variantRow = $(this).closest(".variant");
                if ($("#variant-container .variant").length > 1) {
                    $variantRow.remove();
                }
            });
        });
    </script>
@endsection
