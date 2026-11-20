<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Admin panel - Junior-G</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

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

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link
        href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet">
    <link
        href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}"
        rel="stylesheet">
    {{-- <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet"> --}}

    <!-- datatable -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    <style>
        #big_screen {
            display: block;
        }

        #small_screen {
            display: none;
        }

        @media only screen and (max-width: 600px) {
            #big_screen {
                display: none;
            }

            #small_screen {
                display: block;
            }
        }
    </style>

    @yield('style')

</head>

<body>

    @if (auth()->guard('ecomadmin')->user())
        <!-- ======= Header ======= -->
        <header id="header"
            class="header fixed-top d-flex align-items-center">

            <div class="d-flex align-items-center justify-content-between">
                <a href="/dashboard"
                    class="logo d-flex align-items-center">

                    <img src="{{ asset('ecom/web/assets/img/logo/logo1.webp') }}"
                        alt="Junior-G" title="Junior-G" class="img-fluid"
                        id="big_screen" />

                    <img src="{{ asset('ecom/web/assets/img/logo/logo2.webp') }}"
                        alt="Junior-G" title="Junior-G" class="img-fluid"
                        id="small_screen" />
                </a>
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div>
            <!-- End Logo -->

            {{-- <!-- Go to salon -->
            <div class="search-bar">
                <a href="{{route('goToSalon')}}" class="btn btn-sm btn-primary">
                    <i class="bi bi-heart text-white"></i> Salon
                </a>
            </div>
            <!-- End Go to salon --> --}}

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0"
                            href="#" data-bs-toggle="dropdown">
                            @if (auth()->guard('ecomadmin')->user()->avatar != null)
                                <img src="{{ asset(auth()->guard('ecomadmin')->user()->avatar) }}"
                                    alt="Profile" class="rounded-circle">
                            @else
                                <img src="{{ asset('ecom/web/assets/img/logo/logo2.webp') }}"
                                    alt="Profile" class="rounded-circle">
                            @endif

                            <span
                                class="d-none d-md-block dropdown-toggle ps-2">
                                {{ ucfirst(auth()->guard('ecomadmin')->user()->name) }}
                            </span>
                        </a>
                        <!-- End Profile Image Icon -->
                        <ul
                            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>
                                    <!-- first letter capital -->
                                    {{ ucfirst(auth()->guard('ecomadmin')->user()->name) }}
                                </h6>
                                <span>Web Designer</span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="users-profile.html">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="users-profile.html">
                                    <i class="bi bi-gear"></i>
                                    <span>Account Settings</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="pages-faq.html">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Need Help?</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('ecomLogout') }}">
                                    <h6><i
                                            class="bx bx-log-out-circle"></i>
                                        Sign Out</h6>
                                </a>
                            </li>

                        </ul><!-- End Profile Dropdown Items -->
                    </li><!-- End Profile Nav -->
                </ul>
            </nav><!-- End Icons Navigation -->
        </header><!-- End Header -->


        <!-- ======= Sidebar ======= -->
        @include('ecom.admin.layouts.sidebar')


        <main id="main" class="main">

            @yield('content')

        </main>
        <!-- End #main -->
    @else
        @yield('content')
    @endif

    {{-- <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Junior-G</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer --> --}}

    <a href="#"
        class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}">
    </script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- datatable -->
    <script
        src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js">
    </script>
    <script
        src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js">
    </script>
    <script src="{{ asset('assets/js/dt.js') }}"></script>

    <!-- Select2 -->
    <script
        src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js">
    </script>
    @yield('script')

</body>

</html>
