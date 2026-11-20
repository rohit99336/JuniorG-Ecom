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
                                    <div class="card-header">Create New Role
                                    </div>
                                    <div class="card-body">
                                        <form
                                            action="{{ route('ecomadmin.authorization.roles.store') }}"
                                            method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name"
                                                    class="form-label">Name:</label>
                                                <input type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    placeholder="Enter role name">
                                            </div>
                                            <div class="mb-3">
                                                <strong>Permissions:</strong>
                                                <br>


                                                @foreach ($permissions as $key => $permission)
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            name="permission[]"
                                                            id="{{$key+1}}"
                                                            value="{{$permission->name}}">
                                                        <label
                                                            class="form-check-label"
                                                            for="{{$key+1}}">{{$permission->name}}</label>
                                                    </div>
                                                @endforeach 
                                            </div>
                                            <div class="text-center">
                                                <button type="submit"
                                                    class="btn btn-primary">Submit</button>
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
