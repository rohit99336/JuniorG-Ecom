@extends('ecom.web.layouts.app')

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
                                <h4>Reset Password</h4>
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
                                            action="{{ route('shop.postresetpassword') }}">
                                            @csrf

                                            <input type="hidden"
                                                name="token"
                                                value="{{ $customer->password_reset_token }}">

                                            <input type="text"
                                                name="name"
                                                value="{{ $customer->name }}"
                                                readonly>

                                            <input type="text"
                                                name="email"
                                                value="{{ $customer->email ?? old('email') }}"
                                                autocomplete="email" readonly
                                                required>

                                            <input id="password"
                                                type="password"
                                                name="password"
                                                autocomplete="new-password"
                                                placeholder="New password"
                                                required
                                                autofocus>

                                            <input id="password-confirm"
                                                type="password"
                                                name="password_confirmation"
                                                required
                                                placeholder="Confirm password"
                                                autocomplete="confirm-password">

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
                <form class="login-form common-form mx-auto"
                action="{{ route('shop.postresetpassword') }}" method="post">
                    @csrf
                    <div class="section-header mb-3">
                        <h2 class="section-heading text-center">Reset Password</h2>
                    </div>
                    @include('ecom.web.layouts.messages')
                    <div class="row">
                        <input type="hidden"
                                                name="token"
                                                value="{{ $customer->password_reset_token }}">
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Full name</label>
                                <input type="text"  name="name"
                                value="{{ $customer->name }}"
                                readonly />
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Email address</label>
                                <input name="email"
                                value="{{ $customer->email ?? old('email') }}"
                                autocomplete="email" readonly />
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Password</label>
                                <input type="password" name="password"
                                    required />
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Confirm password</label>
                                <input type="password" name="password_confirmation"
                                    required />
                            </fieldset>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    {{-- <strong>ReCaptcha:</strong> --}}
                                    <div class="g-recaptcha"
                                        data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                    </div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span
                                            class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <button type="submit"
                                class="btn-primary d-block mt-3 btn-signin">SUBMIT</button>
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
