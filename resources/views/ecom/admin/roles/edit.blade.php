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

                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">Edit Role
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('ecomadmin.authorization.roles.update', $role->id) }}">
                                            @csrf
                                            @method('PATCH')
                                        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name"><strong>Name:</strong></label>
                                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name', $role->name) }}">
                                                    </div>
                                                </div>
                                        
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <strong>Permissions:</strong><br>
                                                        @foreach($permission as $value)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="permission[]" id="permission{{ $value->id }}" value="{{ $value->name }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission{{ $value->id }}">
                                                                    {{ $value->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                        
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
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
