@extends('ecom.web.layouts.app')

@section('meta')
    <title>Junior-G - Premium Baby Products for Happy Families</title>
    <meta name="description"
        content="Discover a delightful range of premium baby products at Junior-G. Our collection includes baby clothing, accessories, toys, and essentials crafted with love and care. Shop now for your little ones!">
    <meta name="keywords"
        content="Junior-G, baby products, baby clothing, baby accessories, baby toys, premium baby products">
@endsection

@section('styles')
    <style>
        /* Hide temp-2 by default */
        .temp-2 {
            display: none;
        }

        /* Media query for small screens (max-width: 767px) */
        @media (max-width: 767px) {
            .temp-1 {
                display: none;
                /* Hide temp-1 on small screens */
            }

            .temp-2 {
                display: block;
                /* Show temp-2 on small screens */
            }
        }

        .mt-70 {
            margin-top: 70px;
        }

        .mt-50{
            margin-top: 50px;
        }
    </style>
@endsection

@section('content')
    <main id="MainContent" class="content-for-layout">
        {{-- <!-- slideshow start -->
        <div class="slideshow-section position-relative">
            <div class="slideshow-active activate-slider"
                data-slick='{
                    "slidesToShow": 1,
                    "slidesToScroll": 1,
                    "dots": true,
                    "arrows": true,
                    "responsive": [
                        {
                        "breakpoint": 768,
                        "settings": {
                            "arrows": false
                        }
                        }
                    ]
                }'>
                @foreach ($advertisements as $advertisement)
                    <div class="slide-item slide-item-bag position-relative">
                        <img class="slide-img d-none d-md-block"
                            src="{{ $advertisement->image }}"
                            alt="{{ $advertisement->title }}">
                        <img class="slide-img d-md-none"
                            src="{{ $advertisement->image }}"
                            alt="{{ $advertisement->title }}">
                        <div class="content-absolute content-slide">
                            <div
                                class="container height-inherit d-flex align-items-center">
                                <div class="content-box slide-content py-4">
                                    <h2 class="slide-heading heading_72 animate__animated animate__fadeInUp"
                                        data-animation="animate__animated animate__fadeInUp">
                                        ZEN VIVID 16
                                    </h2>
                                    <p class="slide-subheading heading_18 animate__animated animate__fadeInUp"
                                        data-animation="animate__animated animate__fadeInUp">
                                        Look for your inspiration here
                                    </p>
                                    <a class="btn-primary slide-btn animate__animated animate__fadeInUp"
                                        href="collection-left-sidebar.html"
                                        data-animation="animate__animated animate__fadeInUp">SHOP
                                        NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="activate-arrows"></div>
            <div class="activate-dots dot-tools"></div>
        </div>
        <!-- slideshow end --> --}}

        <!-- slideshow start -->
        <div id="slider" class="carousel slide cslide big-slider"
            data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($advertisements as $advertisement)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}"
                        data-bs-interval="4000">
                        <img src="{{ $advertisement->image }}"
                            class="d-block w-100" alt="ads">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button"
                data-bs-target="#slider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"
                    aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button"
                data-bs-target="#slider" data-bs-slide="next">
                <span class="carousel-control-next-icon"
                    aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div id="slider2" class="carousel slide cslide small-slider"
            data-bs-ride="carousel">

            <div class="carousel-inner">
                @foreach ($mobile_ads as $ad)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}"
                        data-bs-interval="4000">
                        <img src="{{ $ad->image }}" class="d-block w-100"
                            alt="ads">
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button"
                data-bs-target="#slider2" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"
                    aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button"
                data-bs-target="#slider2" data-bs-slide="next">
                <span class="carousel-control-next-icon"
                    aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- slideshow end -->

        <!-- trusted badge start -->
        <div class="trusted-section overflow-hidden">
            <div class="trusted-section-inner">
                <div class="container">
                    <div
                        class="row mt-100 justify-content-center trusted-row temp-1">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="trusted-badge bg-trust-1 rounded">
                                <div class="trusted-icon">
                                    <img class="icon-trusted"
                                        src="{{ asset('ecom/web/assets/img/icon/icons8-expert-100.png') }}"
                                        alt="icon-1">
                                </div>
                                <div class="trusted-content">
                                    <h2 class="heading_18 trusted-heading">
                                        Expertly Crafted
                                    </h2>
                                    <p
                                        class="text_16 trusted-subheading trusted-subheading-2">
                                        Crafted by Experts
                                        {{-- ₹{{ $ecomProps->free_shipping_amount }} --}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="trusted-badge bg-trust-2 rounded">
                                <div class="trusted-icon">
                                    <img class="icon-trusted"
                                        src=" {{ asset('ecom/web/assets/img/icon/icons8-tasty-100.png') }}"
                                        alt="icon-2">
                                </div>
                                <div class="trusted-content">
                                    <h2 class="heading_18 trusted-heading">
                                        Kid-Approved Taste
                                    </h2>
                                    <p
                                        class="text_16 trusted-subheading trusted-subheading-2">
                                        Deliciously Fun Kids Love Them
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="trusted-badge bg-trust-3 rounded">
                                <div class="trusted-icon">
                                    <img class="icon-trusted"
                                        src=" {{ asset('ecom/web/assets/img/icon/icons8-thumbs-up-100.png') }}"
                                        alt="icon-3">
                                </div>
                                <div class="trusted-content">
                                    <h2 class="heading_18 trusted-heading">
                                        Parents-Approved Quality
                                    </h2>
                                    <p
                                        class="text_16 trusted-subheading trusted-subheading-2">
                                        Trusted by Parents Nationwide
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-70 gx-2 gy-2">
                        <div class="col-4 temp-2">
                            <div class="card">
                                <img src="{{ asset('ecom/web/assets/img/checkout/free-delivery.webp') }}"
                                    class="card-img-top" alt="Free Delivery">
                            </div>
                        </div>

                        <div class="col-4 temp-2">
                            <div class="card">
                                <img src="{{ asset('ecom/web/assets/img/checkout/customer.webp') }}"
                                    class="card-img-top"
                                    alt="Customer Support">
                            </div>
                        </div>

                        <div class="col-4 temp-2">
                            <div class="card">
                                <img src="{{ asset('ecom/web/assets/img/checkout/cod.webp') }}"
                                    class="card-img-top"
                                    alt="Money Back Guarantee">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- trusted badge end -->

        <!-- collection start -->
        <div class="featured-collection mt-50 overflow-hidden">
            <div class="collection-tab-inner">
                <div class="container">
                    <div class="section-header text-center">
                        <h2 class="section-heading">Popular Products
                        </h2>
                    </div>
                    <div class="row">
                        @if (count($feacherdProducts) >= 1)
                            @foreach ($feacherdProducts as $key => $product)
                                @php
                                    $product_variants =
                                        $product->productVariants;
                                    $product_variant = $product_variants->first();
                                @endphp

                                @if ($product_variant)
                                    <div class="col-lg-3 col-md-6 col-6"
                                        data-aos="fade-up"
                                        data-aos-duration="700">
                                        <div class="product-card">
                                            <div class="product-card-img">
                                                <a class="hover-switch"
                                                    href="{{ route('shop.product', $product_variant->uuid) }}">
                                                    <img class="secondary-img"
                                                        src="{{ $product_variant->thumbnail_image }}"
                                                        alt="{{ $product->name }}">
                                                    <img class="primary-img"
                                                        src="{{ $product_variant->thumbnail_image }}"
                                                        alt="{{ $product->name }}">
                                                </a>
                                                @if (!$product_variant->quantity > 0)
                                                    <div
                                                        class="product-badge">
                                                        <span
                                                            class="badge-label badge-percentage rounded">Sold
                                                            Out</span>
                                                    </div>
                                                @endif

                                                @if ($product_variant->quantity > 0)
                                                    <div
                                                        class="product-card-action product-card-action-2 justify-content-center">
                                                        <a href="{{ route('shop.product', $product_variant->uuid) }}"
                                                            class="action-card action-quickview">

                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="26"
                                                                height="26"
                                                                viewBox="0 0 24 24"
                                                                style="fill: #004D0D;transform: ;msFilter:;">
                                                                <path
                                                                    d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z">
                                                                </path>
                                                                <path
                                                                    d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z">
                                                                </path>
                                                            </svg>
                                                        </a>

                                                        <a href="{{ route('addToCart', ['product_variant_id' => $product_variant->uuid]) }}"
                                                            class="action-card action-addtocart"
                                                            title="Add to cart">

                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="24"
                                                                height="26"
                                                                fill="#004D0D"
                                                                class="bi bi-bag-plus"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    fill-rule="evenodd"
                                                                    d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5" />
                                                                <path
                                                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div
                                                        class="product-card-action product-card-action-2 justify-content-center">

                                                        <a href="{{ route('shop.product', $product_variant->uuid) }}"
                                                            class="action-card action-quickview"
                                                            title="Detail">

                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="26"
                                                                height="26"
                                                                viewBox="0 0 24 24"
                                                                style="fill: #004D0D;transform: ;msFilter:;">
                                                                <path
                                                                    d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z">
                                                                </path>
                                                                <path
                                                                    d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z">
                                                                </path>
                                                            </svg>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="action-card action-quickview fw-bold"
                                                            title="Sold Out">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="24"
                                                                height="24"
                                                                fill="#004D0D"
                                                                class="bi bi-bag-x"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    fill-rule="evenodd"
                                                                    d="M6.146 8.146a.5.5 0 0 1 .708 0L8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 0 1 0-.708" />
                                                                <path
                                                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div
                                                class="product-card-details text-center">
                                                <h3
                                                    class="product-card-title ">
                                                    <a
                                                        href="{{ route('shop.product', $product_variant->uuid) }}">{{ $product->name }}</a>
                                                </h3>
                                                <div
                                                    class="product-card-price">
                                                    <span
                                                        class="card-price-regular">₹
                                                        {{ $product_variant->price }}</span>
                                                    <span
                                                        class="card-price-compare text-decoration-line-through">₹
                                                        {{ $product_variant->org_price }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="view-all text-center" data-aos="fade-up"
                        data-aos-duration="700">
                        <a class="btn-primary"
                            href="{{ route('shop.products', ['is_featured' => 'is_featured']) }}">VIEW
                            ALL</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- collection end -->

        {{-- <!-- banner start -->
        <div class="banner-section mt-100 overflow-hidden">
            <div class="banner-section-inner">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 col-12"
                            data-aos="fade-right" data-aos-duration="1200">
                            <a class="banner-item position-relative rounded"
                                href="collection-left-sidebar.html">
                                <img class="banner-img"
                                    src="assets/img/banner/shoe-1.jpg"
                                    alt="banner-1">
                                <div class="content-absolute content-slide">
                                    <div
                                        class="container height-inherit d-flex align-items-center">
                                        <div
                                            class="content-box banner-content p-4">
                                            <p
                                                class="heading_18 mb-3 text-white">
                                                Sports Shoes</p>
                                            <h2 class="heading_34 text-white">
                                                25% off for <br>sports
                                                men</h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12"
                            data-aos="fade-left" data-aos-duration="1200">
                            <a class="banner-item position-relative rounded"
                                href="collection-left-sidebar.html">
                                <img class="banner-img"
                                    src="assets/img/banner/shoe-2.jpg"
                                    alt="banner-2">
                                <div class="content-absolute content-slide">
                                    <div
                                        class="container height-inherit d-flex align-items-center">
                                        <div
                                            class="content-box banner-content p-4">
                                            <p
                                                class="heading_18 mb-3 text-white">
                                                Sports Shoes</p>
                                            <h2 class="heading_34 text-white">
                                                25% off for <br>sports
                                                women</h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- banner end --> --}}

        <!-- featured collection start -->
        <div
            class="featured-collection-section mt-100 home-section overflow-hidden">
            <div class="container">
                <div class="section-header text-center">
                    <p class="section-subheading">WHAT'S NEW</p>
                    <h2 class="section-heading">The Latest Drop</h2>
                </div>

                <div class="product-container position-relative">
                    <div class="common-slider"
                        data-slick='{
                            "slidesToShow": 4,
                            "slidesToScroll": 1,
                            "dots": false,
                            "arrows": true,
                            "responsive": [
                            {
                                "breakpoint": 1281,
                                "settings": {
                                "slidesToShow": 3
                                }
                            },
                            {
                                "breakpoint": 768,
                                "settings": {
                                "slidesToShow": 2
                                }
                            }
                            ]
                        }'>
                        @if (count($products) >= 1)
                            @foreach ($products as $key => $product)
                                @php
                                    $product_variants =
                                        $product->productVariants;
                                    $product_variant = $product_variants->first();
                                @endphp

                                @if ($product_variant)
                                    <div class="new-item" data-aos="fade-up"
                                        data-aos-duration="700">
                                        <div class="product-card">
                                            <div class="product-card-img">
                                                <a class="hover-switch"
                                                    href="{{ route('shop.product', $product_variant->uuid) }}">
                                                    <img class="secondary-img"
                                                        src="{{ $product_variant->thumbnail_image }}"
                                                        alt="{{ $product->name }}">
                                                    <img class="primary-img"
                                                        src="{{ $product_variant->thumbnail_image }}"
                                                        alt="{{ $product->name }}">
                                                </a>
                                                @if (!$product_variant->quantity > 0)
                                                    <div
                                                        class="product-badge">
                                                        <span
                                                            class="badge-label badge-percentage rounded">Sold
                                                            Out</span>
                                                    </div>
                                                @endif

                                                @if ($product_variant->quantity > 0)
                                                    <div
                                                        class="product-card-action product-card-action-2 justify-content-center">
                                                        <a href="{{ route('shop.product', $product_variant->uuid) }}"
                                                            class="action-card action-quickview">

                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="26"
                                                                height="26"
                                                                viewBox="0 0 24 24"
                                                                style="fill: #004D0D;transform: ;msFilter:;">
                                                                <path
                                                                    d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z">
                                                                </path>
                                                                <path
                                                                    d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z">
                                                                </path>
                                                            </svg>
                                                        </a>

                                                        <a href="{{ route('addToCart', ['product_variant_id' => $product_variant->uuid]) }}"
                                                            class="action-card action-addtocart"
                                                            title="Add to cart">

                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="24"
                                                                height="26"
                                                                fill="#004D0D"
                                                                class="bi bi-bag-plus"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    fill-rule="evenodd"
                                                                    d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5" />
                                                                <path
                                                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div
                                                        class="product-card-action product-card-action-2 justify-content-center">

                                                        <a href="{{ route('shop.product', $product_variant->uuid) }}"
                                                            class="action-card action-quickview"
                                                            title="Detail">

                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="26"
                                                                height="26"
                                                                viewBox="0 0 24 24"
                                                                style="fill: #004D0D;transform: ;msFilter:;">
                                                                <path
                                                                    d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z">
                                                                </path>
                                                                <path
                                                                    d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z">
                                                                </path>
                                                            </svg>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="action-card action-quickview fw-bold"
                                                            title="Sold Out">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="24"
                                                                height="24"
                                                                fill="#004D0D"
                                                                class="bi bi-bag-x"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    fill-rule="evenodd"
                                                                    d="M6.146 8.146a.5.5 0 0 1 .708 0L8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 0 1 0-.708" />
                                                                <path
                                                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                            <div
                                                class="product-card-details text-center">
                                                <h3
                                                    class="product-card-title ">
                                                    <a
                                                        href="{{ route('shop.product', $product_variant->uuid) }}">{{ $product->name }}</a>
                                                </h3>
                                                <div
                                                    class="product-card-price">
                                                    <span
                                                        class="card-price-regular">₹
                                                        {{ $product_variant->price }}</span>
                                                    <span
                                                        class="card-price-compare text-decoration-line-through">₹
                                                        {{ $product_variant->org_price }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div
                        class="activate-arrows show-arrows-always article-arrows arrows-white">
                    </div>
                </div>
            </div>
        </div>
        <!-- featured collection end -->

        {{-- <!-- single banner start -->
        <div class="single-banner-section mt-100 overflow-hidden">
            <div class="position-relative overlay">
                <img class="single-banner-img"
                    src="assets/img/banner/single-banner.jpg" alt="slide-1">

                <div class="content-absolute content-slide">
                    <div
                        class="container height-inherit d-flex align-items-center">
                        <div class="content-box single-banner-content py-4">
                            <h2 class="single-banner-heading heading_42 text-white animate__animated animate__fadeInUp"
                                data-animation="animate__animated animate__fadeInUp">
                                Climb up to the mountain with NIK
                            </h2>
                            <p class="single-banner-text text_16 text-white animate__animated animate__fadeInUp"
                                data-animation="animate__animated animate__fadeInUp">
                                Free shipping, and no hassle returns.
                                NIK Running shoes for men & women
                            </p>
                            <a class="btn-primary single-banner-btn animate__animated animate__fadeInUp"
                                href="collection-left-sidebar.html"
                                data-animation="animate__animated animate__fadeInUp">
                                SHOP NOW
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- single banner end -->

        <!-- instagram start -->
        <div class="instagram-section mt-100 overflow-hidden home-section">
            <div class="instagram-inner">
                <div class="container">
                    <div class="section-header text-center">
                        <div class="section-icon">
                            <svg width="54" height="54"
                                viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.99998 2.62165C12.4031 2.62165 12.6877 2.6308 13.6367 2.6741C14.5142 2.71415 14.9908 2.86077 15.3079 2.98398C15.728 3.14725 16.0278 3.34231 16.3428 3.65723C16.6577 3.97215 16.8528 4.272 17.016 4.69206C17.1392 5.00923 17.2859 5.48577 17.3259 6.36323C17.3692 7.31228 17.3783 7.5969 17.3783 10C17.3783 12.4031 17.3692 12.6878 17.3259 13.6368C17.2859 14.5143 17.1392 14.9908 17.016 15.308C16.8528 15.728 16.6577 16.0279 16.3428 16.3428C16.0278 16.6577 15.728 16.8528 15.3079 17.016C14.9908 17.1393 14.5142 17.2859 13.6367 17.3259C12.6879 17.3692 12.4032 17.3784 9.99998 17.3784C7.59672 17.3784 7.3121 17.3692 6.36323 17.3259C5.48574 17.2859 5.00919 17.1393 4.69206 17.016C4.27196 16.8528 3.97212 16.6577 3.6572 16.3428C3.34227 16.0279 3.14721 15.728 2.98398 15.308C2.86073 14.9908 2.71411 14.5143 2.67406 13.6368C2.63076 12.6878 2.62162 12.4031 2.62162 10C2.62162 7.5969 2.63076 7.31228 2.67406 6.36326C2.71411 5.48577 2.86073 5.00923 2.98398 4.69206C3.14721 4.272 3.34227 3.97215 3.6572 3.65723C3.97212 3.34231 4.27196 3.14725 4.69206 2.98398C5.00919 2.86077 5.48574 2.71415 6.36319 2.6741C7.31224 2.6308 7.59687 2.62165 9.99998 2.62165ZM9.99998 1C7.55571 1 7.24926 1.01036 6.28931 1.05416C5.33133 1.09789 4.67712 1.25001 4.10462 1.47251C3.51279 1.70251 3.01088 2.01025 2.51055 2.51058C2.01021 3.01092 1.70247 3.51283 1.47247 4.10466C1.24997 4.67716 1.09785 5.33137 1.05412 6.28935C1.01032 7.24926 1 7.55575 1 10C1 12.4443 1.01032 12.7508 1.05412 13.7107C1.09785 14.6687 1.24997 15.3229 1.47247 15.8954C1.70247 16.4872 2.01021 16.9891 2.51055 17.4895C3.01088 17.9898 3.51279 18.2975 4.10462 18.5275C4.67712 18.75 5.33133 18.9021 6.28931 18.9459C7.24926 18.9897 7.55571 19 9.99998 19C12.4443 19 12.7507 18.9897 13.7107 18.9459C14.6686 18.9021 15.3228 18.75 15.8953 18.5275C16.4872 18.2975 16.9891 17.9898 17.4894 17.4895C17.9898 16.9891 18.2975 16.4872 18.5275 15.8954C18.75 15.3229 18.9021 14.6687 18.9458 13.7107C18.9896 12.7508 19 12.4443 19 10C19 7.55575 18.9896 7.24926 18.9458 6.28935C18.9021 5.33137 18.75 4.67716 18.5275 4.10466C18.2975 3.51283 17.9898 3.01092 17.4894 2.51058C16.9891 2.01025 16.4872 1.70251 15.8953 1.47251C15.3228 1.25001 14.6686 1.09789 13.7107 1.05416C12.7507 1.01036 12.4443 1 9.99998 1ZM9.99998 5.37838C7.44753 5.37838 5.37835 7.44757 5.37835 10C5.37835 12.5525 7.44753 14.6217 9.99998 14.6217C12.5524 14.6217 14.6216 12.5525 14.6216 10C14.6216 7.44757 12.5524 5.37838 9.99998 5.37838ZM9.99998 13C8.34314 13 6.99996 11.6569 6.99996 10C6.99996 8.34317 8.34314 7 9.99998 7C11.6568 7 13 8.34317 13 10C13 11.6569 11.6568 13 9.99998 13ZM15.8842 5.19579C15.8842 5.79226 15.4007 6.27581 14.8042 6.27581C14.2077 6.27581 13.7242 5.79226 13.7242 5.19579C13.7242 4.59931 14.2077 4.1158 14.8042 4.1158C15.4007 4.1158 15.8842 4.59931 15.8842 5.19579Z"
                                    fill="#00234D" />
                            </svg>
                        </div>
                        <h2 class="section-heading">Shoe products
                        </h2>
                        <p class="section-subheading">See how our
                            customers styled shoe products in their
                            foot</p>
                    </div>
                    <div class="instagram-container position-relative mt-48">
                        <div class="common-slider"
                            data-slick='{
                        "slidesToShow": 4,
                        "slidesToScroll": 1,
                        "dots": false,
                        "arrows": true,
                        "responsive": [
                          {
                            "breakpoint": 1281,
                            "settings": {
                              "slidesToShow": 3
                            }
                          },
                          {
                            "breakpoint": 768,
                            "settings": {
                              "slidesToShow": 2
                            }
                          }
                        ]
                    }'>
                            <div class="instagram-slick-item"
                                data-aos="fade-up" data-aos-duration="700">
                                <div class="instagram-card">
                                    <a class="instagram-img-wrapper"
                                        href="index-shoe.html">
                                        <img src="assets/img/instagram/s1.jpg"
                                            alt="img"
                                            class="instagram-card-img rounded">
                                    </a>
                                </div>
                            </div>
                            <div class="instagram-slick-item"
                                data-aos="fade-up" data-aos-duration="700">
                                <div class="instagram-card">
                                    <a class="instagram-img-wrapper"
                                        href="index-shoe.html">
                                        <img src="assets/img/instagram/s2.jpg"
                                            alt="img"
                                            class="instagram-card-img rounded">
                                    </a>
                                </div>
                            </div>
                            <div class="instagram-slick-item"
                                data-aos="fade-up" data-aos-duration="700">
                                <div class="instagram-card">
                                    <a class="instagram-img-wrapper"
                                        href="index-shoe.html">
                                        <img src="assets/img/instagram/s3.jpg"
                                            alt="img"
                                            class="instagram-card-img rounded">
                                    </a>
                                </div>
                            </div>
                            <div class="instagram-slick-item"
                                data-aos="fade-up" data-aos-duration="700">
                                <div class="instagram-card">
                                    <a class="instagram-img-wrapper"
                                        href="index-shoe.html">
                                        <img src="assets/img/instagram/s4.jpg"
                                            alt="img"
                                            class="instagram-card-img rounded">
                                    </a>
                                </div>
                            </div>
                            <div class="instagram-slick-item"
                                data-aos="fade-up" data-aos-duration="700">
                                <div class="instagram-card">
                                    <a class="instagram-img-wrapper"
                                        href="index-shoe.html">
                                        <img src="assets/img/instagram/s2.jpg"
                                            alt="img"
                                            class="instagram-card-img rounded">
                                    </a>
                                </div>
                            </div>
                            <div class="instagram-slick-item"
                                data-aos="fade-up" data-aos-duration="700">
                                <div class="instagram-card">
                                    <a class="instagram-img-wrapper"
                                        href="index-shoe.html">
                                        <img src="assets/img/instagram/s4.jpg"
                                            alt="img"
                                            class="instagram-card-img rounded">
                                    </a>
                                </div>
                            </div>
                            <div class="instagram-slick-item"
                                data-aos="fade-up" data-aos-duration="700">
                                <div class="instagram-card">
                                    <a class="instagram-img-wrapper"
                                        href="index-shoe.html">
                                        <img src="assets/img/instagram/s1.jpg"
                                            alt="img"
                                            class="instagram-card-img rounded">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div
                            class="activate-arrows show-arrows-always article-arrows arrows-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- instagram end --> --}}

        @include('ecom.web.layouts.newsletter')

        {{-- @include('ecom.web.layouts.brand') --}}

        @include('ecom.web.layouts.news-model')
    </main>
@endsection
