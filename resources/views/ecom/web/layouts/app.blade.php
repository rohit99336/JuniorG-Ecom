<!doctype html>
<html lang="en" class="no-js">

<head>

    @yield('meta')

    <!-- meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!---- =========================================== --->
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57"
        href="{{ asset('ecom/web/assets/img/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60"
        href="{{ asset('ecom/web/assets/img/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset('ecom/web/assets/img/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ asset('ecom/web/assets/img/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('ecom/web/assets/img/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120"
        href="{{ asset('ecom/web/assets/img/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144"
        href="{{ asset('ecom/web/assets/img/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ asset('ecom/web/assets/img/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('ecom/web/assets/img/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('ecom/web/assets/img/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('ecom/web/assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96"
        href="{{ asset('ecom/web/assets/img/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('ecom/web/assets/img/favicon/favicon-16x16.png') }}">
    <link rel="manifest"
        href="{{ asset('ecom/web/assets/img/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage"
        content="{{ asset('ecom/web/assets/img/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#e72f49">

    <!-- og meta tags -->
    <meta property="og:title" content="Junior-G - Baby Products" />
    <meta property="og:description"
        content="Explore a wide range of baby products at Junior-G. From clothing to toys, find everything for your little ones." />
    <meta property="og:image"
        content="{{ asset('ecom/web/assets/img/logo/logo2.webp') }}" />
    <meta property="og:url" content="https://juniorg.in/" />
    <meta property="og:site_name" content="Junior-G - Baby Products" />
    <meta property="og:type" content="website" />

    <!-- OG Image -->
    <meta property="og:image"
        content="{{ asset('ecom/web/assets/img/logo/logo1.webp') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- OG Site Name (optional) -->
    <meta property="og:site_name" content="Junior-G">

    <!-- OG Locale (optional) -->
    <meta property="og:locale" content="en_US">
    <!---- =========================================== --->


    <!-- all css -->
    <style>
        :root {
            --primary-color: #e72f49;
            --secondary-color: #e72f49;

            --btn-primary-border-radius: 0.25rem;
            --btn-primary-color: #fff;
            --btn-primary-background-color: #e72f49;
            --btn-primary-border-color: #e72f49;
            --btn-primary-hover-color: #fff;
            --btn-primary-background-hover-color: #e72f49;
            --btn-primary-border-hover-color: #e72f49;
            --btn-primary-font-weight: 500;

            --btn-secondary-border-radius: 0.25rem;
            --btn-secondary-color: #004D04;
            --btn-secondary-background-color: transparent;
            --btn-secondary-border-color: #004D04;
            --btn-secondary-hover-color: #fff;
            --btn-secondary-background-hover-color: #e72f49;
            --btn-secondary-border-hover-color: #e72f49;
            --btn-secondary-font-weight: 500;

            --heading-color: #000;
            --heading-font-family: 'Poppins', sans-serif;
            --heading-font-weight: 700;

            --title-color: #000;
            --title-font-family: 'Poppins', sans-serif;
            --title-font-weight: 400;

            --body-color: #000;
            --body-background-color: #fff;
            --body-font-family: 'Poppins', sans-serif;
            --body-font-size: 14px;
            --body-font-weight: 400;

            --section-heading-color: #000;
            --section-heading-font-family: 'Poppins', sans-serif;
            --section-heading-font-size: 48px;
            --section-heading-font-weight: 600;

            --section-subheading-color: #000;
            --section-subheading-font-family: 'Poppins', sans-serif;
            --section-subheading-font-size: 16px;
            --section-subheading-font-weight: 400;
        }
    </style>

    <link rel="stylesheet"
        href="{{ asset('ecom/web/assets/css/vendor.css') }}">

    <link rel="stylesheet"
        href="{{ asset('ecom/web/assets/css/style.css') }}">

    <link rel="stylesheet"
        href="{{ asset('ecom/web/assets/css/cart.css') }}">

    <link rel="stylesheet"
        href="{{ asset('ecom/web/assets/css/tostr.min.css') }}">

    <link
        href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}"
        rel="stylesheet">

    <link
        href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}"
        rel="stylesheet">

    <link rel="stylesheet"
        href="{{ asset('ecom/web/assets/css/custom1.css') }}">

    <script src='https://www.google.com/recaptcha/api.js'></script>

    @yield('styles')

    <!-------- External dev------------------------------>

    <!-- google-site-verificatio -->
    <meta name="google-site-verification"
        content="Wj5zJONMyvoU8xnjMt_kwfNqOIQHg4NedUYcHv-09kk">

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-M452MC9T');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe
            src="https://www.googletagmanager.com/ns.html?id=GTM-M3NBT43G"
            height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!------------------------------- External Prince ------------------------------>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TJLR4CM7');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Taboola Pixel Code -->
    <script type='text/javascript'>
        window._tfa = window._tfa || [];
        window._tfa.push({
            notify: 'event',
            name: 'page_view',
            id: 1717382
        });
        ! function(t, f, a, x) {
            if (!document.getElementById(x)) {
                t.async = 1;
                t.src = a;
                t.id = x;
                f.parentNode.insertBefore(t, f);
            }
        }(document.createElement('script'),
            document.getElementsByTagName('script')[0],
            '//cdn.taboola.com/libtrc/unip/1717382/tfa.js',
            'tb_tfa_script');
    </script>
    <!-- End of Taboola Pixel Code -->

</head>

<body>
    <div class="body-wrapper">
        @include('ecom.web.layouts.header')

        @yield('content')

        @include('ecom.web.layouts.footer')

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe
                src="https://www.googletagmanager.com/ns.html?id=GTM-M452MC9T"
                height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <!-- scrollup start -->
        <button id="scrollup">
            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" viewBox="0 0 24 24" fill="none"
                stroke="#fff" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <polyline points="18 15 12 9 6 15"></polyline>
            </svg>
        </button>
        <!-- scrollup end -->

        @include('ecom.web.layouts.drawer-menu')

        {{-- @include('ecom.web.layouts.drawer-cart') --}}

        {{-- @include('ecom.web.layouts.product-view') --}}

        {{-- @include('ecom.web.layouts.news-model') --}}

        <!-- all js -->
        <script src="{{ asset('ecom/web/assets/js/vendor.js') }}"></script>
        <script src="{{ asset('ecom/web/assets/js/main.js') }}"></script>
        <script src="{{ asset('ecom/web/assets/js/tostr.min.js') }}"></script>

        <script>
            // Default Configuration
            $(document).ready(function() {
                toastr.options = {
                    'closeButton': true,
                    'debug': false,
                    'newestOnTop': false,
                    'progressBar': false,
                    'positionClass': 'toast-top-right',
                    'preventDuplicates': false,
                    'showDuration': '1000',
                    'hideDuration': '1000',
                    'timeOut': '5000',
                    'extendedTimeOut': '1000',
                    'showEasing': 'swing',
                    'hideEasing': 'linear',
                    'showMethod': 'fadeIn',
                    'hideMethod': 'fadeOut',
                }

                // toastr.success('test');

                @if (Session::has('success'))
                    toastr.success("{{ Session::get('success') }}");
                @endif

                @if (Session::has('error'))
                    toastr.error("{{ Session::get('error') }}");
                @endif

                @if (Session::has('info'))
                    toastr.info("{{ Session::get('info') }}");
                @endif

            });

            // close alert automatically after 3 seconds
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        </script>

        @yield('scripts')
    </div>
</body>

</html>
