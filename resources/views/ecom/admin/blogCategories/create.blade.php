@extends('ecom.admin.layouts.app')


@section('content')
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('ecomadmin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row mt-4">
            <div class="col-md-8 m-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New category</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    aria-label="Close">
                                </button>

                                <strong>Error!</strong> Please fix the following issues:
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="row g-3 needs-validation" action="{{ route('ecomadmin.blog.blog-category.store') }}"
                            method="POST" novalidate>
                            @csrf
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">
                                    Category name
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Please enter category name" required>

                                    <div class="invalid-feedback">
                                        Please enter category name.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">
                                    Parent category
                                </label>
                                <div class="col-sm-9">
                                    <select class="select2 form-select" id="parent_id" name="parent_id">
                                        <option value="">
                                            Select category
                                        </option>
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                        Please select a category.
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row mb-3">
                                <label for="lfm" class="col-sm-3 col-form-label">Image(200*200)</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="cat_img" data-preview="cat_img_holder"
                                                class="btn btn-success lfm">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="cat_img" class="form-control" type="text" name="image" required
                                            placeholder="Please select image" readonly>

                                        <div class="invalid-feedback">
                                            Please enter category name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <img id="cat_img_holder" style="margin-top:15px;max-height:100px;">
                                </div>
                            </div> --}}

                            {{-- <div class="row mb-3">
                                <label for="lfm" class="col-sm-3 col-form-label">Icon(32x32)</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                class="btn btn-success lfm">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="text" name="icon" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <img id="holder" style="margin-top:15px;max-height:100px;">
                                </div>
                            </div> --}}

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">
                                    Category description
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="03"></textarea>

                                    <div class="invalid-feedback">
                                        Please enter category description.
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form><!-- End General Form Elements -->

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

            $('.lfm').filemanager('file');

            // Listen for changes in the "cat_img" input field
            $('#cat_img').change(function() {
                var imageUrl = $(this).val();
                $('#cat_img_holder').attr('src', imageUrl);
            });

            // Listen for changes in the "thumbnail" input field
            $('#thumbnail').change(function() {
                var imageUrl = $(this).val();
                $('#holder').attr('src', imageUrl);
            });

            $(".select2").select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                // allowClear: true
            });
        });
    </script>
@endsection
