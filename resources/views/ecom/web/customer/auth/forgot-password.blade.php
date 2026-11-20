@extends('ecom.web.layouts.app')

@section('meta')
    <title>Shrivenu Naturals -Shop : login</title>
@endsection

@section('styles')
@endsection

@section('content')
    {{-- <div class="login-register-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ms-auto me-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-bs-toggle="tab" href="#lg1">
                                <h4> Reset Your Password </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <div>
                                            @if ($errors->any())
                                                <ul class="alert">
                                                    @foreach ($errors->all() as $error)
                                                        <li
                                                            class="text-danger">
                                                            {{ $error }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            @if (session('success'))
                                                <div
                                                    class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            @if (session('error'))
                                                <div
                                                    class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                        </div>

                                        <form method="POST"
                                            action="{{ route('shop.postforgotpassword') }}">
                                            @csrf

                                            <input type="text"
                                                name="email"
                                                placeholder="Enter your registerd email">

                                            <div class="button-box">
                                                <button type="submit">
                                                    <span>Submit</span>
                                                </button>
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
    </div> --}}

    <main id="MainContent" class="content-for-layout">
        <div class="login-page mt-70">
            <div class="container">

                <div class="section-header mt-5">
                    <h2 class="section-heading text-center">
                        Reset Your Password
                    </h2>
                </div>

                @include('ecom.web.layouts.messages')

                <form action="{{ route('shop.postforgotpassword') }}"
                    class="login-form common-form mx-auto" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Email address</label>
                                <input type="email" name="email" />
                            </fieldset>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit"
                                class="btn-primary d-block mt-3 btn-signin">SUBMIT</button>
                            <a href="{{ route('shop.login') }}"
                                class="btn-secondary mt-3 btn-signin">RETURN TO LOGIN</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        // Assuming you have a form with id "myForm"
        var form = document.getElementById('reg_form');

        form.addEventListener('submit', function(event) {
            // Prevent form submission if phone number is invalid
            if (!checkPhone(form.phone.value)) {
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
@endsection
