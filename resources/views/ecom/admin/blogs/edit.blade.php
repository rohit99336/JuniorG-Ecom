@extends('ecom.admin.layouts.app')

@section('style')
    {{-- <script
        src="https://cdn.ckeditor.com/ckeditor5/41.2.1/super-build/ckeditor.js">
    </script> --}}

    <script src="{{ asset('ecom/admin/ckeditor.js') }}"></script>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('ecomadmin.dashboard') }}">Home</a>
                </li>
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
                            <div class="alert alert-danger alert-dismissible fade show mt-5"
                                role="alert">
                                <button type="button" class="btn-close"
                                    data-bs-dismiss="alert" aria-label="Close"
                                    aria-label="Close">
                                    {{-- <span aria-hidden="true">&times;</span> --}}
                                </button>

                                <strong>Error!</strong> Please fix the
                                following issues:
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="row g-3 needs-validation mt-2"
                            action="{{ route('ecomadmin.blog.blogs.update', $blog->id) }}"
                            method="POST">
                            @csrf
                            @method('put')


                            <div class="col-md-6">
                                <label for="title" class="col-form-label">
                                    Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control"
                                    id="title" name="title"
                                    value="{{ $blog->title ?? old('title') }}"
                                    placeholder="Enter title" required>
                            </div>

                            <div class="col-md-6">
                                <label for="inputText" class="col-form-label">
                                    Blog Category <span
                                        class="text-danger">*</span>
                                </label>
                                <select class="select2 form-select"
                                    id="category_id" name="category_id">
                                    <option value="">
                                        Select category
                                    </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $blog->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="tag" class="col-form-label">
                                    Tags
                                </label>
                                <textarea name="tag" id="tag" cols="30" rows="1"
                                    class="form-control" placeholder="Enter tags">{{ $blog->tag }}</textarea>

                                <sub>
                                    (You can enter multiple tags
                                    with
                                    each separated by comma)
                                </sub>
                            </div>

                            <div class="col-md-6">
                                <label for="lfm" class="mb-2">
                                    Image(<small>750x440</small>)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="image"
                                            data-preview="holder"
                                            class="btn btn-success lfm">
                                            <i class="fa fa-picture-o"></i>
                                            Choose
                                        </a>
                                    </span>
                                    <input id="image" class="form-control"
                                        type="text" name="thumbnail_img" value="{{ $blog->thumbnail_img }}"
                                        readonly>
                                </div>
                                <div class="col-md-12 text-center">
                                    <img id="img_holder"
                                        src="{{ $blog->thumbnail_img }}"
                                        style="margin-top:15px;max-height:100px;">
                                </div>
                            </div>


                            <div class="col-12">
                                <label for="meta_description"
                                    class="col-form-label">
                                    Meta Description
                                </label>
                                <textarea name="meta_description" id="meta_description" cols="30"
                                    rows="1" class="form-control">{{ $blog->meta_description ?? old('meta_description') }}</textarea>

                                <div class="invalid-feedback">
                                    Please enter meta description.
                                </div>
                            </div>


                            <div class="col-12">
                                <label for="meta_keywords"
                                    class="col-form-label">
                                    Meta Keywords
                                </label>
                                <textarea name="meta_keywords" id="meta_keywords" cols="30"
                                    rows="1" class="form-control">{{ $blog->meta_keywords ?? old('meta_keywords') }}</textarea>

                                <sub>
                                    (You can enter multiple meta keywords
                                    with
                                    each separated by comma)
                                </sub>

                                <div class="invalid-feedback">
                                    Please enter meta keywords.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="editor" class="col-form-label">
                                    Content <span class="text-danger">*</span>
                                </label>
                                <div id="editor" class="m-4">
                                    {!! $blog->content !!}
                                </div>
                                <input type="hidden" name="content"
                                    value="" id="hiddenInput">
                                <div class="invalid-feedback"
                                    id="errorContent">Please provide a valid
                                    message
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit"
                                    class="btn btn-primary float-end">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script
        src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}">
    </script>
    <script src="{{ asset('vendor/laravel-filemanager/js/filemanager.js') }}">
    </script>

    <!--  include CKEDITOR js -->
    <script src="{{ asset('ecom/admin/useckeditor.js') }}"></script>

    <script></script>

    <script>
        $(document).ready(function() {
            // close alert automatically after 3 seconds
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });

            $('.lfm').filemanager('file');

            // Listen for changes in the file input
            $('#image').change(function() {
                var imageUrl = $(this).val();
                $('#img_holder').attr('src', imageUrl);
            });
        });

        // jQuery document ready function
        $(document).ready(function() {
            // Get the content from the editor div
            var blogContent = $('#editor').html();

            // Set the content value to the hidden input
            $('#hiddenInput').val(blogContent);
        });
    </script>
@endsection
