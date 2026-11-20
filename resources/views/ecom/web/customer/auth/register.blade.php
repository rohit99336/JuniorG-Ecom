@extends('ecom.web.layouts.app')

@section('meta')
    <title>Junior-G - Register for New Account</title>
    <meta name="description"
        content="Create a new account at Junior-G to explore our delightful range of baby products. Enjoy exclusive benefits, promotions, and a personalized shopping experience for your little ones.">
    <meta name="keywords"
        content="Junior-G, baby products registration, baby account registration, baby products sign up, baby essentials registration">
@endsection

@section('styles')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <main id="MainContent" class="content-for-layout">
        <div class="login-page mt-70">
            <div class="container">
                <form class="login-form common-form mx-auto"
                    action="{{ route('shop.register') }}" method="post">
                    @csrf
                    <div class="section-header mb-3">
                        <h2 class="section-heading text-center">Register</h2>
                    </div>
                    @include('ecom.web.layouts.messages')
                    <div class="row">
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Full name</label>
                                <input type="text" name="name"
                                    required />
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Email address</label>
                                <input type="email" name="email"
                                    required />
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset>
                                <label class="label">Phone number</label>
                                <input type="text" name="phone" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    minlength="10" maxlength="10" />
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
                                <input type="password" name="confirm_password"
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

                        <div class="col-12 mt-3 text-center">
                            <button type="submit" class="btn btn-primary btn-block btn-signin">CREATE</button>
                            <span class="my-2 d-block">OR</span>
                            <a href="{{ route('shop.auth.google') }}" class="btn btn-block btn-signin border">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#db4437" class="bi bi-google" viewBox="0 0 16 16">
                                    <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                                </svg>
                                <span class="ml-2">Signup with Google</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('styles')
@endsection
