@extends('ecom.admin.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('ecomadmin.dashboard') }}">Home</a></li>
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

                        <div>
                            @if ($errors->any())
                                <ul class="alert">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">
                                            {{ $error }}</li>
                                    @endforeach
                                </ul>
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
                        </div>

                        <form class="row g-3 needs-validation"
                            action="{{ route('ecomadmin.authorization.permissions.store') }}"
                            method="POST" novalidate>
                            @csrf

                            <div class="col-md-6">
                                <label for="title"
                                    class="form-label">Name</label>
                                <input type="text" class="form-control"
                                    id="title" name="name"
                                    value="{{ old('name') }}" required>
                                <div class="invalid-feedback">
                                    Please enter role name.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="guard_name"
                                    class="form-label">Guard name</label>
                                <input type="text" class="form-control"
                                    id="guard_name" name="guard_name"
                                    value="{{ 'web' ?? old('guard_name') }}"
                                    required>
                                <div class="invalid-feedback">
                                    Please enter guard name.
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary float-end"
                                    type="submit">
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
    <script
        src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}">
    </script>
    <script src="{{ asset('vendor/laravel-filemanager/js/filemanager.js') }}">
    </script>
    <script>
        $(document).ready(function() {
            // close alert automatically after 3 seconds
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>
@endsection
