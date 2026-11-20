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
                        <h5 class="card-title">Edit category</h5>
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

                        <form class="row g-3 needs-validation"
                            action="{{ route('ecomadmin.prod.categories.update', $category->id) }}" method="POST"
                            novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">
                                    Category Name
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') ?? $category->name }}"
                                        placeholder="Please enter category name" required>

                                    <div class="invalid-feedback">
                                        Please enter category name.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="parent_id" class="col-sm-3 col-form-label">
                                    Parent Category
                                </label>
                                <div class="col-sm-9">
                                    <select class="select2 form-select" id="parent_id" name="parent_id">
                                        <option value="">Select category</option>
                                        @php
                                            $selectedCategoryId = old('parent_id', $category->parent_id);
                                            $currentCategoryId = $category->id;
                                        @endphp
                                        @foreach ($categories as $cat)
                                            @if ($cat->id != $currentCategoryId)
                                                <!-- Exclude the current category -->
                                                <option value="{{ $cat->id }}"
                                                    {{ $cat->id == $selectedCategoryId ? 'selected' : '' }}>
                                                    {{ ucfirst($cat->name) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @if ($errors->has('parent_id'))
                                        <div class="invalid-feedback" style="display: block;">
                                            {{ $errors->first('parent_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
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
                                            value="{{ old('image') ?? $category->image }}"
                                            placeholder="Please select image" readonly>

                                        <div class="invalid-feedback">
                                            Please enter category name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <img id="cat_img_holder" style="margin-top:15px;max-height:100px;"
                                        src="{{ $category->image }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="lfm" class="col-sm-3 col-form-label">Icon(32x32)</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                class="btn btn-success lfm">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="text" name="icon"
                                            value="{{ old('icon') ?? $category->icon }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <img id="holder" style="margin-top:15px;max-height:100px;"
                                        src="{{ $category->icon }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">
                                    Category Description
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="03">{{ old('description') ?? $category->description }}
                                    </textarea>

                                    <div class="invalid-feedback">
                                        Please enter category description.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-3 col-form-label">
                                    Status
                                </label>
                                <div class="col-sm-9">
                                    <select class="select2 form-select" id="status" name="status">
                                        <option value="">
                                            Select status
                                        </option>
                                        @php
                                            $sel_status = old('status') ? old('status') : $category->is_active;
                                        @endphp
                                        <option value="1" {{ $sel_status == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ $sel_status == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>

                                    <div class="invalid-feedback">
                                        Please select a category.
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h6 class="fw-bold">SEO Content</h6>

                            <div class="row mb-3">
                                <label for="meta_title" class="col-sm-3 col-form-label">
                                    Meta title
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        value="{{ $category->meta_title ?? old('meta_title') }}"
                                        placeholder="Please enter meta title" required>

                                    <div class="invalid-feedback">
                                        Please enter meta_title.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="meta_keywords" class="col-sm-3 col-form-label">
                                    Meta keywords
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                        value="{{ $category->meta_keywords ?? old('meta_keywords') }}"
                                        placeholder="Keywords with coma separated values" required>

                                    <div class="invalid-feedback">
                                        Please enter meta keywords.
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="meta_description" class="col-sm-3 col-form-label">
                                    Meta description
                                </label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="meta_description" id="meta_description" cols="30" rows="03"
                                        placeholder="Please enter meta description">{{ $category->meta_description ?? old('meta_description') }}</textarea>

                                    <div class="invalid-feedback">
                                        Please enter category meta_description.
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
