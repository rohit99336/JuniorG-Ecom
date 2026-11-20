@extends('admin.layouts.app')


@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('ecomadmin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit course details</h5>

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

                        <form class="row g-3 needs-validation" action="{{ route('courses.update', $course->id) }}"
                            method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select class="select2 form-select" id="category_id" name="course_category_id" required>
                                    <option value="">
                                        Select category
                                    </option>
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $course->course_category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                    Please select a category.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">Course name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $course->name }}" required>
                                <div class="invalid-feedback">
                                    Please enter course name.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" name="price"
                                    value="{{ $course->price }}" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="10" maxlength="10">
                                <div class="invalid-feedback">
                                    Please enter price for course.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="duration" class="form-label">Duration(In Days)</label>
                                <input type="text" class="form-control" id="duration" name="duration"
                                    value="{{ $course->duration }}" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1" maxlength="4">
                                <div class="invalid-feedback">
                                    Please enter duration.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="03">{{ $course->description }}</textarea>
                                <div class="invalid-feedback">
                                    Please enter course description.
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <label for="image" class="form-label">Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-success">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="image" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img id="holder" style="margin-top:15px;max-height:100px;">
                            </div> --}}

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
