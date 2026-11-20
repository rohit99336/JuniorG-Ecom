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
    <div class="error-page mt-100">
        <div class="container">
            <div class="error-content text-center">
                <div class="error-img mx-auto">
                    <img src="{{asset('ecom/web/assets/img/error/error.png')}}" alt="error">
                </div>
                <p class="error-subtitle">Page Not Found</p>
                <a href="{{route('shop.index')}}" class="btn-primary mt-4">BACK TO HOMEPAGE</a>
            </div>
        </div>
    </div>
</main>
@endsection

@section('styles')
@endsection
