@extends('ecom.web.layouts.app')

@section('meta')
    <title>Junior-G - Natural Baby Foods & Products</title>
    <meta name="description"
        content="Explore our selection of natural baby foods and products at Junior-G. We offer a range of organic baby foods and gentle baby care items for your little one's needs.">
    <meta name="keywords"
        content="Junior-G, baby foods, organic baby food, natural baby products, baby care, infant nutrition, organic snacks for babies, baby feeding, eco-friendly baby products">
@endsection

@section('styles')
@endsection

@section('content')
    @include('ecom.web.layouts.bradcamp')

    <main id="MainContent" class="content-for-layout">
        <div class="collection mt-5">
            <div class="container">
                <div class="row">
                    <!-- product area start -->
                    <div class="col-lg-12 col-md-12 col-12">
                        <div
                            class="filter-sort-wrapper d-flex justify-content-between flex-wrap">
                            <div
                                class="collection-title-wrap d-flex align-items-end">
                                <h2 class="collection-title heading_24 mb-0">
                                    All products
                                </h2>
                                <p
                                    class="collection-counter text_16 mb-0 ms-2">
                                    ({{ count($products) }} items)
                                </p>
                            </div>
                            <div class="filter-sorting">
                                <div
                                    class="collection-sorting position-relative d-none d-lg-block">
                                    <div
                                        class="sorting-header text_16 d-flex align-items-center justify-content-end">
                                        <span class="sorting-title me-2">Sort
                                            by:</span>
                                        <span
                                            class="active-sorting">Featured</span>
                                        <span class="sorting-icon">
                                            <svg class="icon icon-down"
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-chevron-down">
                                                <polyline
                                                    points="6 9 12 15 18 9">
                                                </polyline>
                                            </svg>
                                        </span>
                                    </div>
                                    <ul
                                        class="sorting-lists list-unstyled m-0">
                                        <li>
                                            <a href="{{ route('shop.products', ['is_featured' => 'is_featured']) }}"
                                                class="text_14">
                                                Featured
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('shop.products', ['is_bestseller' => 'is_bestseller']) }}"
                                                class="text_14">
                                                Best Selling
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('shop.products', ['a_to_z' => 'a_to_z']) }}"
                                                class="text_14">
                                                Alphabetically,
                                                A-Z
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('shop.products', ['z_to_a' => 'z_to_a']) }}"
                                                class="text_14">
                                                Alphabetically,
                                                Z-A
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('shop.products', ['low_to_high' => 'low_to_high']) }}"
                                                class="text_14">
                                                Price, low to
                                                high
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('shop.products', ['high_to_low' => 'high_to_low']) }}"
                                                class="text_14">
                                                Price, high to
                                                low
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('shop.products', ['old_to_new' => 'old_to_new']) }}"
                                                class="text_14">
                                                Date, old to
                                                new
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('shop.products', ['new_to_old' => 'new_to_old']) }}"
                                                class="text_14">
                                                Date, new to
                                                old
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div
                                    class="filter-drawer-trigger mobile-filter d-flex align-items-center d-lg-none">
                                    <span class="mobile-filter-icon me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24"
                                            viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="icon icon-filter">
                                            <polygon
                                                points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3">
                                            </polygon>
                                        </svg>
                                    </span>
                                    <span
                                        class="mobile-filter-heading">Sorting</span>
                                </div>
                            </div>
                        </div>
                        <div class="collection-product-container">
                            <div class="row">
                                @if (!empty($products) && $products->count())
                                    @foreach ($products as $key => $product)
                                        @php
                                            $product_variants =
                                                $product->productVariants;
                                            // $product_variant = $product_variants->first();

                                            // get lowest price product variant
                                            $product_variant = $product_variants
                                                ->sortBy('price')
                                                ->first();
                                        @endphp

                                        @if ($product_variant)
                                            <div class="col-lg-3 col-md-6 col-6"
                                                data-aos="fade-up"
                                                data-aos-duration="700">
                                                <div class="product-card">
                                                    <div
                                                        class="product-card-img">
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

                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="26" fill="#004D0D" class="bi bi-bag-plus" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5"/>
                                                                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
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
                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
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
                                                        {{-- <ul
                                                    class="color-lists list-unstyled d-flex align-items-center">
                                                    <li><a href="javascript:void(0)"
                                                            class="color-swatch swatch-black active"></a>
                                                    </li>
                                                    <li><a href="javascript:void(0)"
                                                            class="color-swatch swatch-cyan"></a>
                                                    </li>
                                                    <li><a href="javascript:void(0)"
                                                            class="color-swatch swatch-purple"></a>
                                                    </li>
                                                </ul> --}}
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
                        </div>

                        <!-- pagination -->
                        {{ $products->appends(request()->except('page'))->links() }}
                    </div>
                    <!-- product area end -->

                    <!-- sidebar start -->
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="collection-filter filter-drawer">
                            <div
                                class="filter-widget d-lg-none d-flex align-items-center justify-content-between">
                                <h5 class="heading_24">Sorting By</h5>
                                    <button type="button"
                                        class="btn-close text-reset filter-drawer-trigger d-lg-none"></button>
                            </div>

                            <div class="filter-widget d-lg-none">
                                <div class="filter-header faq-heading heading_18 d-flex align-items-center justify-content-between border-bottom"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#filter-mobile-sort">
                                    <span>
                                        <span class="sorting-title me-2">Sort
                                            by:</span>
                                        <span
                                            class="active-sorting">Featured</span>
                                    </span>
                                    <span class="faq-heading-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24"
                                            viewBox="0 0 24 24"
                                            fill="none" stroke="#000"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="icon icon-down">
                                            <polyline points="6 9 12 15 18 9">
                                            </polyline>
                                        </svg>
                                    </span>
                                </div>
                                <div id="filter-mobile-sort"
                                    class="accordion-collapse collapse show">
                                    <ul
                                        class="sorting-lists-mobile list-unstyled m-0">
                                        <li>
                                            <a href="#" class="text_14">Featured</a>
                                        </li>
                                        <li>
                                            <a href="#" class="text_14">
                                                Best Selling
                                            </a>
                                            </li>
                                        <li><a href="#"
                                                class="text_14">Alphabetically,
                                                A-Z</a></li>
                                        <li><a href="#"
                                                class="text_14">Alphabetically,
                                                Z-A</a></li>
                                        <li><a href="#"
                                                class="text_14">Price, low to
                                                high</a></li>
                                        <li><a href="#"
                                                class="text_14">Price, high to
                                                low</a></li>
                                        <li><a href="#"
                                                class="text_14">Date, old to
                                                new</a></li>
                                        <li><a href="#"
                                                class="text_14">Date, new to
                                                old</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- sidebar end -->
                </div>
            </div>
        </div>

        {{-- @include('ecom.web.layouts.newsletter') --}}
        {{-- @include('ecom.web.layouts.news-model') --}}
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#short_by').on('change', function() {
                var short_by = $(this).val();
                var url = "{{ route('shop.products') }}";
                if (short_by) {
                    url = url + '?' + short_by;
                }
                window.location.href = url;
            });
        });
    </script>
@endsection
