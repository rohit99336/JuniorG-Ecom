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
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form class="row g-3 needs-validation mt-2"
                            action="{{ route('ecomadmin.posts.update', $post->id) }}"
                            method="POST">
                            @csrf
                            @method('put')


                            <div class="col-12">
                                <label for="title" class="col-form-label">
                                    Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control"
                                    id="title" name="postTitle"
                                    value="{{ $post->title ?? old('title') }}"
                                    placeholder="Enter title" required>
                            </div>

                            <div class="col-12">
                                <label for="editor" class="col-form-label">
                                    Content <span class="text-danger">*</span>
                                </label>
                                <div id="editor" class="m-4">
                                    {!! $post->body !!}
                                </div>
                                <input type="hidden" name="content"
                                    value="{{ $post->body }}"
                                    id="hiddenInput">
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
