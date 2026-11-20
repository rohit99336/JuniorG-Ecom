@php
    $cartCount = 0;
    if (session()->has('cart')) {
        $cartCount = count(session()->get('cart'));
    }

    // get cart data from session
    $cartData = session()->get('cart');
    $total = 0; // Initializing total
    $grandTotal = 0;
    $noOfItems = 0;
    $shippingCharge = $ecomProps->shipping_charge;
    $free_shipping_amount = $ecomProps->free_shipping_amount;

    if ($cartData && count($cartData) > 0) {
        $noOfItems = count($cartData);
        // Null check and count check
        foreach ($cartData as $item) {
            // Assuming each $item is an associative array with 'price' and 'quantity' keys
            $total += $item['price'] * $item['quantity'];
            $grandTotal = $total;
        }
    }

    // if total is greater than or equal to free shipping amount, then shipping charge is 0 else shipping charge is $shippingCharge and add it to grand total
    if ($total >= $free_shipping_amount) {
        $shippingCharge = 0;
    } else {
        $grandTotal += $shippingCharge;
    }

@endphp

<!-- announcement bar start -->
<div class="announcement-bar bg-6 py-1 py-lg-2">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-3 d-lg-block d-none">
                <div class="announcement-call-wrapper">
                    <div class="announcement-call">
                        <a class="announcement-text text-white"
                            href="tel:+91{{ $ecomProps->phone }}">Call:
                            +91{{ $ecomProps->phone }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div
                    class="announcement-text-wrapper d-flex align-items-center justify-content-center">
                    <p class="announcement-text text-white">Free delivery
                        on order over -
                        ₹{{ $ecomProps->free_shipping_amount }}</p>
                </div>
            </div>
            <div class="col-lg-3 d-lg-block d-none">
                <div
                    class="announcement-meta-wrapper d-flex align-items-center justify-content-end">
                    <div
                        class="announcement-meta d-flex align-items-center">
                        @if (!auth()->guard('customer')->user())
                            <a class="announcement-login announcement-text text-white"
                                href="{{ route('shop.login') }}">
                                <svg class="icon icon-user" width="10"
                                    height="11" viewBox="0 0 10 11"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 0C3.07227 0 1.5 1.57227 1.5 3.5C1.5 4.70508 2.11523 5.77539 3.04688 6.40625C1.26367 7.17188 0 8.94141 0 11H1C1 8.78516 2.78516 7 5 7C7.21484 7 9 8.78516 9 11H10C10 8.94141 8.73633 7.17188 6.95312 6.40625C7.88477 5.77539 8.5 4.70508 8.5 3.5C8.5 1.57227 6.92773 0 5 0ZM5 1C6.38672 1 7.5 2.11328 7.5 3.5C7.5 4.88672 6.38672 6 5 6C3.61328 6 2.5 4.88672 2.5 3.5C2.5 2.11328 3.61328 1 5 1Z"
                                        fill="#fff" />
                                </svg>
                                <span>Login</span>
                            </a>
                            <span class="separator-login d-flex px-3">
                                <svg width="2" height="9"
                                    viewBox="0 0 2 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M1 0.5V8.5"
                                        stroke="#FEFEFE"
                                        stroke-linecap="round" />
                                </svg>
                            </span>
                            <a class="announcement-login announcement-text text-white"
                                href="{{ route('shop.registerform') }}">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="17" height="17"
                                    fill="currentColor"
                                    class="bi bi-person-vcard"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" />
                                    <path
                                        d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z" />
                                </svg>
                                <span>Register</span>
                            </a>
                        @else
                            <a class="announcement-login announcement-text text-white"
                                href="{{ route('shop.logout') }}">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24"
                                    viewBox="0 0 24 24"
                                    style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                    <path d="m2 12 5 4v-3h9v-2H7V8z">
                                    </path>
                                    <path
                                        d="M13.001 2.999a8.938 8.938 0 0 0-6.364 2.637L8.051 7.05c1.322-1.322 3.08-2.051 4.95-2.051s3.628.729 4.95 2.051 2.051 3.08 2.051 4.95-.729 3.628-2.051 4.95-3.08 2.051-4.95 2.051-3.628-.729-4.95-2.051l-1.414 1.414c1.699 1.7 3.959 2.637 6.364 2.637s4.665-.937 6.364-2.637c1.7-1.699 2.637-3.959 2.637-6.364s-.937-4.665-2.637-6.364a8.938 8.938 0 0 0-6.364-2.637z">
                                    </path>
                                </svg>
                                <span>Logout</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- announcement bar end -->

<!-- header start -->
<header class="sticky-header border-btm-black">
    <div class="header-top border-btm-black">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-4">
                    <div class="header-logo">
                        <a href="{{ route('shop.index') }}"
                            class="logo-main">
                            <img src="{{ asset('ecom/web/assets/img/logo/logo1.webp') }}"
                                loading="lazy" alt="bisum">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-block d-none">
                    <div class="header-search">
                        <form action="{{ route('shop.products') }}"
                            method="get" role="search"
                            class="search-form d-flex justify-content-center">
                            <div class="field field-search">
                                <input class="field-input input-reset"
                                    type="search" name="search"
                                    value=""
                                    placeholder="Search here"
                                    autocomplete="off">
                                <button class="search-button btn-reset"
                                    type="submit">
                                    <svg class="icon icon-search"
                                        width="20" height="20"
                                        viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.75 0.250183C11.8838 0.250183 15.25 3.61639 15.25 7.75018C15.25 9.54608 14.6201 11.1926 13.5625 12.4846L19.5391 18.4611L18.4609 19.5392L12.4844 13.5627C11.1924 14.6203 9.5459 15.2502 7.75 15.2502C3.61621 15.2502 0.25 11.884 0.25 7.75018C0.25 3.61639 3.61621 0.250183 7.75 0.250183ZM7.75 1.75018C4.42773 1.75018 1.75 4.42792 1.75 7.75018C1.75 11.0724 4.42773 13.7502 7.75 13.7502C11.0723 13.7502 13.75 11.0724 13.75 7.75018C13.75 4.42792 11.0723 1.75018 7.75 1.75018Z"
                                            fill="black" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-8 col-8">
                    <div
                        class="header-action d-flex align-items-center justify-content-end">
                        <a class="header-action-item header-search d-lg-none"
                            href="javascript:void(0)">
                            <svg class="icon icon-search" width="20"
                                height="20" viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.75 0.250183C11.8838 0.250183 15.25 3.61639 15.25 7.75018C15.25 9.54608 14.6201 11.1926 13.5625 12.4846L19.5391 18.4611L18.4609 19.5392L12.4844 13.5627C11.1924 14.6203 9.5459 15.2502 7.75 15.2502C3.61621 15.2502 0.25 11.884 0.25 7.75018C0.25 3.61639 3.61621 0.250183 7.75 0.250183ZM7.75 1.75018C4.42773 1.75018 1.75 4.42792 1.75 7.75018C1.75 11.0724 4.42773 13.7502 7.75 13.7502C11.0723 13.7502 13.75 11.0724 13.75 7.75018C13.75 4.42792 11.0723 1.75018 7.75 1.75018Z"
                                    fill="black" />
                            </svg>
                        </a>

                        {{-- <a class="header-action-item header-wishlist ms-4 d-none d-lg-block"
                            href="wishlist.html">
                            <svg class="icon icon-wishlist" width="26"
                                height="22" viewBox="0 0 26 22"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.96429 0.000183105C3.12305 0.000183105 0 3.10686 0 6.84843C0 8.15388 0.602121 9.28455 1.16071 10.1014C1.71931 10.9181 2.29241 11.4425 2.29241 11.4425L12.3326 21.3439L13 22.0002L13.6674 21.3439L23.7076 11.4425C23.7076 11.4425 26 9.45576 26 6.84843C26 3.10686 22.877 0.000183105 19.0357 0.000183105C15.8474 0.000183105 13.7944 1.88702 13 2.68241C12.2056 1.88702 10.1526 0.000183105 6.96429 0.000183105ZM6.96429 1.82638C9.73912 1.82638 12.3036 4.48008 12.3036 4.48008L13 5.25051L13.6964 4.48008C13.6964 4.48008 16.2609 1.82638 19.0357 1.82638C21.8613 1.82638 24.1429 4.10557 24.1429 6.84843C24.1429 8.25732 22.4018 10.1584 22.4018 10.1584L13 19.4036L3.59821 10.1584C3.59821 10.1584 3.14844 9.73397 2.69866 9.07411C2.24888 8.41426 1.85714 7.55466 1.85714 6.84843C1.85714 4.10557 4.13867 1.82638 6.96429 1.82638Z"
                                    fill="black" />
                            </svg>
                        </a> --}}

                        @if (auth()->guard('customer')->user())
                            <a class="header-action-item header-wishlist ms-4 d-none d-lg-block"
                                href="{{ route('shop.myprofile') }}">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="26" height="26"
                                    fill="black" class="bi bi-person"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                </svg>
                            </a>
                        @endif

                        <a class="header-action-item header-cart ms-4"
                            href="{{ route('shop.cart') }}">
                            <svg class="icon icon-cart" width="24"
                                height="26" viewBox="0 0 24 26"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 0.000183105C9.25391 0.000183105 7 2.25409 7 5.00018V6.00018H2.0625L2 6.93768L1 24.9377L0.9375 26.0002H23.0625L23 24.9377L22 6.93768L21.9375 6.00018H17V5.00018C17 2.25409 14.7461 0.000183105 12 0.000183105ZM12 2.00018C13.6562 2.00018 15 3.34393 15 5.00018V6.00018H9V5.00018C9 3.34393 10.3438 2.00018 12 2.00018ZM3.9375 8.00018H7V11.0002H9V8.00018H15V11.0002H17V8.00018H20.0625L20.9375 24.0002H3.0625L3.9375 8.00018Z"
                                    fill="black" />
                            </svg>
                            <span class="w-bold cart-items">
                                {{ $cartCount }}
                            </span>
                        </a>


                        <a class="header-action-item header-hamburger ms-4 d-lg-none"
                            href="#drawer-menu"
                            data-bs-toggle="offcanvas">
                            <svg class="icon icon-hamburger"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24"
                                viewBox="0 0 24 24" fill="none"
                                stroke="#000" stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="3" y1="12"
                                    x2="21" y2="12"></line>
                                <line x1="3" y1="6"
                                    x2="21" y2="6"></line>
                                <line x1="3" y1="18"
                                    x2="21" y2="18"></line>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="search-wrapper d-lg-none">
            <div class="container">
                <form action="{{ route('shop.products') }}"
                    class="search-form d-flex align-items-center">
                    <button type="submit"
                        class="search-submit bg-transparent pl-0 text-start">
                        <svg class="icon icon-search" width="20"
                            height="20" viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.75 0.250183C11.8838 0.250183 15.25 3.61639 15.25 7.75018C15.25 9.54608 14.6201 11.1926 13.5625 12.4846L19.5391 18.4611L18.4609 19.5392L12.4844 13.5627C11.1924 14.6203 9.5459 15.2502 7.75 15.2502C3.61621 15.2502 0.25 11.884 0.25 7.75018C0.25 3.61639 3.61621 0.250183 7.75 0.250183ZM7.75 1.75018C4.42773 1.75018 1.75 4.42792 1.75 7.75018C1.75 11.0724 4.42773 13.7502 7.75 13.7502C11.0723 13.7502 13.75 11.0724 13.75 7.75018C13.75 4.42792 11.0723 1.75018 7.75 1.75018Z"
                                fill="black" />
                        </svg>
                    </button>
                    <div class="search-input mr-4">
                        <input type="text" name="search"
                            placeholder="Search your products..."
                            autocomplete="off">
                    </div>
                    <div class="search-close">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24"
                            viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-close">
                            <line x1="18" y1="6"
                                x2="6" y2="18">
                            </line>
                            <line x1="6" y1="6"
                                x2="18" y2="18">
                            </line>
                        </svg>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="header-bottom d-lg-block d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <nav class="site-navigation">
                        <ul class="main-menu list-unstyled">
                            <li
                                class="menu-list-item nav-item has-dropdown {{ Route::currentRouteNamed('shop.index') ? 'active' : '' }}">
                                <div class="mega-menu-header">
                                    <a class="nav-link"
                                        href="{{ route('shop.index') }}">
                                        Home
                                    </a>
                                </div>
                            </li>
                            <li
                                class="menu-list-item nav-item has-megamenu {{ Route::currentRouteNamed('shop.products') ? 'active' : '' }}">
                                <div class="mega-menu-header">
                                    <a class="nav-link"
                                        href="{{ route('shop.products') }}">
                                        Products
                                    </a>
                                </div>
                            </li>
                            <li
                                class="menu-list-item nav-item has-megamenu {{ Route::currentRouteNamed('shop.blog') ? 'active' : '' }}">
                                <div class="mega-menu-header">
                                    <a class="nav-link"
                                        href="{{ route('shop.blog') }}">
                                        Blog
                                    </a>
                                </div>
                            </li>
                            <li
                                class="menu-list-item nav-item has-megamenu {{ Route::currentRouteNamed('shop.contactus') ? 'active' : '' }}">
                                <a class="nav-link"
                                    href="{{ route('shop.contactus') }}">Contact</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-2">
                    <div class="member-signup d-flex justify-content-end">
                        <a href="{{route('shop.posts')}}" target="_blank"
                            class="btn-member text-white">Be a
                            member</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->
