@extends('ecom.admin.layouts.app')

@section('content')
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row ">
                                        <a href="/login" class="d-flex align-items-center w-auto m-auto mt-5">
                                            <img src="{{ asset('ecom/web/assets/img/logo/logo1.webp') }}" alt="Shrivenu" title="" width="200px" height="80px" />
                                        </a>
                                    </div>

                                    <div class="pt-1 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">
                                            {{-- Welcome to Shrivenu --}} Login
                                        </h5>
                                        {{-- <p class="text-center small">Enter your username & password to login</p> --}}
                                    </div>


                                    <form method="POST" action="{{ route('ecomLoginPost') }}" class="row g-3 needs-validation"
                                        novalidate>
                                        @csrf

                                        <div class="col-12">
                                            <label for="emailId" class="form-label">
                                                Email
                                            </label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="emailId"
                                                    required autofocus>
                                                {{-- <div class="invalid-feedback">
                                                    Please enter your email.
                                                </div> --}}

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">
                                                Password
                                            </label>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="yourPassword" required>

                                            {{-- <div class="invalid-feedback">Please enter your password!</div> --}}

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                        {{-- <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="pages-register.html">Create
                                                    an account</a></p>
                                        </div> --}}
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>
@endsection

