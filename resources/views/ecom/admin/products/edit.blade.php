@extends('ecom.admin.layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('ecomadmin.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row mt-4">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" aria-label="Close">
                    </button>

                    <strong>Error!</strong> Please fix the following issues:
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form class="row g-3 needs-validation mt-2" action="{{ route('ecomadmin.prod.products.update', $product->id) }}"
                method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="col-md-8" id="product_div">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Product information</h5>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-4 col-form-label">
                                    Product Category <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <select class="select2 form-select" id="category_id" name="category_id">
                                        <option value="">
                                            Select category
                                        </option>
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a category.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-sm-4 col-form-label">
                                    Product Name <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $product->name }}" placeholder="Product Name" required>

                                    <div class="invalid-feedback">
                                        Please enter product name.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="is_active" class="col-sm-4 col-form-label">
                                    Status
                                </label>
                                <div class="col-sm-8">
                                    <select class="select2 form-select" id="is_active" name="is_active">
                                        <option value="1" {{ $product->is_active == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ $product->is_active == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>

                                    <div class="invalid-feedback">
                                        Please select a category.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="min_quantity" class="col-sm-4 col-form-label">
                                    Min Purchase Qty
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="min_quantity" name="min_quantity"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                        value="{{ $product->min_quantity }}" placeholder="Minimum Purchase Qty" required>

                                    <div class="invalid-feedback">
                                        Please enter minimum purchase qty.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tags" class="col-sm-4 col-form-label">
                                    Tags
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="tags" name="tags"
                                        value="{{ $product->tags }}" placeholder="Tags" multiple>

                                    <sub>
                                        (You can enter multiple tags with
                                        each separated by comma)
                                    </sub>

                                    <div class="invalid-feedback">
                                        Please enter tags.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="meta_description" class="col-sm-4 col-form-label">
                                    Meta Description
                                </label>
                                <div class="col-sm-8">
                                    <textarea name="meta_description" id="meta_description" cols="30" rows="3" class="form-control">{{ $product->meta_description }}</textarea>

                                    <div class="invalid-feedback">
                                        Please enter meta description.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="meta_keywords" class="col-sm-4 col-form-label">
                                    Meta Keywords
                                </label>
                                <div class="col-sm-8">
                                    <textarea name="meta_keywords" id="meta_keywords" cols="30" rows="3" class="form-control">{{ $product->meta_keywords }}
                                    </textarea>

                                    <sub>
                                        (You can enter multiple meta keywords with
                                        each separated by comma)
                                    </sub>

                                    <div class="invalid-feedback">
                                        Please enter meta keywords.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="schema" class="col-sm-4 col-form-label">
                                    Schema Code
                                </label>
                                <div class="col-sm-8">
                                    <textarea name="schema" id="schema" cols="30" rows="3" class="form-control">{{ $product->schema }}</textarea>

                                    <sub>
                                        (Add or paste your schema code)
                                    </sub>

                                    <div class="invalid-feedback">
                                        Please enter schema code.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label for="inputText" class="col-sm-4 col-form-label">
                                    Product Description
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <div class="col-sm-8 mb-5">
                                    <div id="editor">{!! $product->description !!}</div>
                                    <input type="hidden" name="description" id="hiddenInput">
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="no_of_variants" value="{{ count($product->productVariants) }}">
                    @if (count($product->productVariants) > 0)
                        @foreach ($product->productVariants as $varkey => $variant)
                            <div class="card" id="variant_div{{ $varkey + 1 }}">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" class="form-control" id="uuid{{ $varkey + 1 }}" name="variants[{{ $varkey + 1 }}][uuid]"
                                        value="{{ $variant->uuid }}">

                                        <div class="col-md-6">
                                            <h5 class="card-title">Product Variant</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-sm btn-success float-end mt-3 new"
                                                id="new{{ $varkey + 1 }}" title="Add new variant">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-4 col-form-label">
                                            Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="hidden" class="form-control" id="variant_id1"
                                                name="variants[{{ $varkey + 1 }}][variant_id]" value="{{ $variant->id }}" required>
                                            <input type="text" class="form-control" id="name1"
                                                name="variants[{{ $varkey + 1 }}][name]" value="{{ $variant->name }}"
                                                placeholder="Product variant name" required>

                                            <div class="invalid-feedback">
                                                Please enter variant name.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="unit_id" class="col-sm-4 col-form-label">
                                            Unit <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="select2 form-select" id="unit_id{{ $varkey + 1 }}"
                                                name="variants[{{ $varkey + 1 }}][unit_id]" required>
                                                <option value="">
                                                    Select unit
                                                </option>
                                                @foreach ($units as $key => $unit)
                                                    <option value="{{ $unit->id }}"
                                                        {{ $unit->id == $variant->unit_id ? 'selected' : '' }}>
                                                        {{ $unit->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="invalid-feedback">
                                                Please select a unit.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="unit_size" class="col-sm-4 col-form-label">
                                            Size
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="unit_size{{ $varkey + 1 }}"
                                                name="variants[{{ $varkey + 1 }}][unit_size]"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                                value="{{ $variant->unit_size }}"
                                                placeholder="Unit size like 100, 200 etc" required>

                                            <div class="invalid-feedback">
                                                Please enter unit size.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="price" class="col-sm-4 col-form-label">
                                            Price<small>(₹)</small> <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="price{{ $varkey + 1 }}"
                                                name="variants[{{ $varkey + 1 }}][price]"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                                value="{{ $variant->price }}" placeholder="399" required>

                                            <div class="invalid-feedback">
                                                Please enter product price.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="org_price" class="col-sm-4 col-form-label">
                                            Original price<small>(₹)</small> <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="org_price1" name="variants[{{ $varkey + 1 }}][org_price]"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                                value="{{ $variant->org_price ?? old('org_price') }}" placeholder="399" required>

                                            <div class="invalid-feedback">
                                                Please enter product original price.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="color_id" class="col-sm-4 col-form-label">
                                            Color
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="select2 form-select" id="color_id{{ $varkey + 1 }}"
                                                name="variants[{{ $varkey + 1 }}][color_id]">
                                                <option value="">
                                                    Select color
                                                </option>
                                                @foreach ($colors as $key => $color)
                                                    <option value="{{ $color->id }}"
                                                        {{ $color->id == $variant->color_id ? 'selected' : '' }}>
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a color.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="quantity" class="col-sm-4 col-form-label">
                                            Quantity
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="quantity{{ $varkey + 1 }}"
                                                name="variants[{{ $varkey + 1 }}][quantity]"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                                value="{{ $variant->quantity }}" placeholder="1" required>

                                            <div class="invalid-feedback">
                                                Please enter product quantity.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="lfm" class="col-sm-4 col-form-label">
                                            Thumbnail Image<small>(290x300)</small>
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="thumbnail{{ $varkey + 1 }}"
                                                        data-preview="holder" class="btn btn-success lfm">
                                                        <i class="fa fa-picture-o"></i> Choose
                                                    </a>
                                                </span>
                                                <input id="thumbnail{{ $varkey + 1 }}" class="form-control"
                                                    type="text" name="variants[{{ $varkey + 1 }}][thumbnail_image]"
                                                    value="{{ $variant->thumbnail_image }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <img id="holder" style="margin-top:15px;max-height:100px;"
                                                src="{{ $variant->thumbnail_image }}">
                                        </div>
                                    </div>

                                    @if (count($variant->images) > 0)
                                        @foreach ($variant->images as $k => $image)
                                            <div id="img_div{{ $k + 1 }}">
                                                <div class="row mb-3 mt-2">
                                                    <label for="lfm" class="col-sm-4 col-form-label">
                                                        Image<small>(570x680)</small>
                                                    </label>
                                                    <div class="col-sm-7 col-10">
                                                        <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <a id="lfm{{ $k + 1 }}"
                                                                    data-input="cat_img{{ $k + 1 }}"
                                                                    data-preview="cat_img_holder{{ $k + 1 }}"
                                                                    class="btn btn-success lfm">
                                                                    <i class="fa fa-picture-o"></i> Choose
                                                                </a>
                                                            </span>
                                                            <input id="cat_img{{ $k + 1 }}" class="form-control"
                                                                type="text"
                                                                name="variants[{{ $varkey + 1 }}][images][]"
                                                                value="{{ $image->image }}"
                                                                placeholder="Please select image" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1 col-2">
                                                        @if ($k == 0)
                                                            <button type="button"
                                                                class="btn btn-sm btn-info float-end mt-1 new_img"
                                                                id="new_img{{ $k + 1 }}" title="Add new image">
                                                                <i class="bi bi-plus-lg"></i>
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger float-end mt-1 rmv_img"
                                                                id="remv_img{{ $k + 1 }}" title="Remove image">
                                                                <i class="bi bi-dash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 text-center">
                                                        <img id="cat_img_holder{{ $k + 1 }}"
                                                            src="{{ $image->image }}"
                                                            style="margin-top:15px;max-height:100px;">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div id="img_div1">
                                            <div class="row mb-3 mt-2">
                                                <label for="lfm" class="col-sm-4 col-form-label">
                                                    Image<small>(570x680)</small>
                                                </label>
                                                <div class="col-sm-7 col-10">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a id="lfm" data-input="cat_img1"
                                                                data-preview="cat_img_holder" class="btn btn-success lfm">
                                                                <i class="fa fa-picture-o"></i> Choose
                                                            </a>
                                                        </span>
                                                        <input id="cat_img1" class="form-control" type="text"
                                                            name="variants[1][images][]" placeholder="Please select image"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1 col-2">
                                                    <button type="button"
                                                        class="btn btn-sm btn-info float-end mt-1 new_img" id="new_img1"
                                                        title="Add new image">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <img id="cat_img_holder" style="margin-top:15px;max-height:100px;">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card" id="variant_div1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">Product Variant</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-sm btn-success float-end mt-3 new"
                                            id="new1" title="Add new variant">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="unit_id" class="col-sm-4 col-form-label">
                                        Unit <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="unit_id1" name="variants[1][unit_id]"
                                            required>
                                            <option value="">
                                                Select unit
                                            </option>
                                            @foreach ($units as $key => $unit)
                                                <option value="{{ $unit->id }}">
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                            Please select a unit.
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="unit_size" class="col-sm-4 col-form-label">
                                        Size
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="unit_size1"
                                            name="variants[1][unit_size]"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                            value="{{ old('unit_size') }}" placeholder="Unit size like 100, 200 etc"
                                            required>

                                        <div class="invalid-feedback">
                                            Please enter unit size.
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="price" class="col-sm-4 col-form-label">
                                        Price<small>(₹)</small> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="price1"
                                            name="variants[1][price]"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                            value="{{ old('price') }}" placeholder="399" required>

                                        <div class="invalid-feedback">
                                            Please enter product price.
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="color_id" class="col-sm-4 col-form-label">
                                        Color
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="color_id1" name="variants[1][color_id]">
                                            <option value="">
                                                Select color
                                            </option>
                                            @foreach ($colors as $key => $color)
                                                <option value="{{ $color->id }}">
                                                    {{ $color->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a color.
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="quantity" class="col-sm-4 col-form-label">
                                        Quantity
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="quantity1"
                                            name="variants[1][quantity]"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                            value="{{ old('quantity') }}" placeholder="1" required>

                                        <div class="invalid-feedback">
                                            Please enter product quantity.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="lfm" class="col-sm-4 col-form-label">
                                        Thumbnail Image<small>(290x300)</small>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="thumbnail1" data-preview="holder"
                                                    class="btn btn-success lfm">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail1" class="form-control" type="text"
                                                name="variants[1][thumbnail_image]" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <img id="holder" style="margin-top:15px;max-height:100px;">
                                    </div>
                                </div>

                                <div id="img_div1">
                                    <div class="row mb-3 mt-2">
                                        <label for="lfm" class="col-sm-4 col-form-label">
                                            Image<small>(570x680)</small>
                                        </label>
                                        <div class="col-sm-7 col-10">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="cat_img1" data-preview="cat_img_holder"
                                                        class="btn btn-success lfm">
                                                        <i class="fa fa-picture-o"></i> Choose
                                                    </a>
                                                </span>
                                                <input id="cat_img1" class="form-control" type="text"
                                                    name="variants[1][images][]" placeholder="Please select image"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-2">
                                            <button type="button" class="btn btn-sm btn-info float-end mt-1 new_img"
                                                id="new_img1" title="Add new image">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <img id="cat_img_holder" style="margin-top:15px;max-height:100px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"><strong>Refundable</strong></div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <label for="is_refundable" class="col-8 col-form-label">
                                    Status
                                </label>
                                <div class="col-4 mt-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_refundable"
                                            name="is_refundable" {{ $product->is_refundable == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><strong>Cash on Delivery</strong></div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <label for="is_cod" class="col-8 col-form-label">
                                    Status
                                </label>
                                <div class="col-4 mt-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_cod" name="is_cod"
                                            {{ $product->is_cod == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><strong>Is Featured</strong></div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <label for="is_featured" class="col-8 col-form-label">
                                    Status
                                </label>
                                <div class="col-4 mt-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_featured"
                                            name="is_featured" {{ $product->is_featured == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><strong>Is Bestseller</strong></div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <label for="is_bestseller" class="col-8 col-form-label">
                                    Status
                                </label>
                                <div class="col-4 mt-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_bestseller"
                                            name="is_bestseller" {{ $product->is_bestseller == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><strong>Estimate Shipping Time</strong></div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <label for="eastimate_shiping_time" class="col-12 col-form-label">
                                    Shipping Days
                                </label>
                                <div class="col-12 mt-2">
                                    <input type="text" class="form-control" id="eastimate_shiping_time"
                                        name="eastimate_shiping_time"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                        value="{{ $product->eastimate_shiping_time }}" placeholder="5" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><strong>Vat & TAX</strong></div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <label for="shippinng_days" class="col-12 col-form-label">
                                    Tax(GST)
                                </label>
                                <div class="col-7 mt-2">
                                    <select name="tax_type" id="tax_type" class="form-select">
                                        <option value="percentage"
                                            {{ $product->tax_type == 'percentage' ? 'selected' : '' }}>Percentage
                                        </option>
                                        <option value="flat" {{ $product->tax_type == 'flat' ? 'selected' : '' }}>Flat
                                        </option>
                                    </select>
                                </div>
                                <div class="col-5 mt-2">
                                    <input type="text" class="form-control" id="tax" name="tax"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '')" minlength="1"
                                        value="{{ $product->tax }}" placeholder="12" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/filemanager.js') }}"></script>
    <script>
        $(document).ready(function() {
            // close alert automatically after 3 seconds
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });

            $('.lfm').filemanager('file');

            // Listen for changes in the "cat_img" input field
            $('#cat_img1').change(function() {
                var imageUrl = $(this).val();
                $('#cat_img_holder').attr('src', imageUrl);
            });

            // Listen for changes in the "thumbnail" input field
            $('#thumbnail1').change(function() {
                var imageUrl = $(this).val();
                $('#holder').attr('src', imageUrl);
            });

            $(".select2").select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                // allowClear: true
            });

            // get quill-editor-default input data and store in textarea
            var quill = new Quill('#editor', {
                theme: 'snow'
            });

            var form = document.querySelector("form");
            var hiddenInput = document.querySelector('#hiddenInput');

            form.addEventListener('submit', function(e) {
                hiddenInput.value = quill.root.innerHTML;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var i = 1;
            var no_of_variants = $('#no_of_variants').val();
            if (no_of_variants > 0) {
                i = no_of_variants;
            } else {
                i = 1;
            }

            var j = 5000;

            // Event delegation for "Add new variant" button
            $('#product_div').on('click', '.new', function() {
                i++;
                j++;

                // Create a new variant HTML
                let variant = `<div class="card" id="variant_div${i}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Product Variant</h5>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="float-end">
                                        <button type="button" class="btn btn-sm btn-success mt-3 new ml-2" id="new${i}"
                                        title="Add new variant">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-danger mt-3  remove" id="remove${i}"
                                            title="Remove variant">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-sm-4 col-form-label">
                                    Name
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="hidden" class="form-control" id="variant_id${i}"
                                                name="variants[${i}][variant_id]" value="">

                                    <input type="text" class="form-control" id="name${i}" name="variants[${i}][name]"
                                        value="{{ old('name') }}" placeholder="Product variant name" required>

                                    <div class="invalid-feedback">
                                        Please enter variant name.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="unit_id" class="col-sm-4 col-form-label">
                                    Unit <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <select class="select2 form-select" id="unit_id${i}" name="variants[${i}][unit_id]" required>
                                        <option value="">
                                            Select unit
                                        </option>
                                        @foreach ($units as $key => $unit)
                                            <option value="{{ $unit->id }}">
                                                {{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                        Please select a unit.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="unit_size" class="col-sm-4 col-form-label">
                                    Size
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="unit_size${i}" name="variants[${i}][unit_size]"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                        value="{{ old('unit_size') }}" placeholder="Unit size like 100, 200 etc"
                                        required>

                                    <div class="invalid-feedback">
                                        Please enter unit size.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="price" class="col-sm-4 col-form-label">
                                    Price<small>(₹)</small> <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="price${i}"
                                        name="variants[${i}][price]"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                        value="{{ old('price') }}" placeholder="399"
                                        required>

                                    <div class="invalid-feedback">
                                        Please enter price.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="org_price" class="col-sm-4 col-form-label">
                                    Original price<small>(₹)</small> <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="org_price${i}"
                                        name="variants[${i}][org_price]"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                        value="{{ old('org_price') }}" placeholder="399"
                                        required>

                                    <div class="invalid-feedback">
                                        Please enter org_price.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="color_id" class="col-sm-4 col-form-label">
                                    Color
                                </label>
                                <div class="col-sm-8">
                                    <select class="select2 form-select" id="color_id${i}" name="variants[${i}][color_id]">
                                        <option value="">
                                            Select color
                                        </option>
                                        @foreach ($colors as $key => $color)
                                            <option value="{{ $color->id }}">
                                                {{ $color->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                        Please select a color.
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="quantity" class="col-sm-4 col-form-label">
                                    Quantity <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="quantity${i}"
                                        name="variants[${i}][quantity]"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="1"
                                        value="{{ old('quantity') }}" placeholder="1"
                                        required>

                                    <div class="invalid-feedback">
                                        Please enter quantity.
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <label for="lfm" class="col-sm-4 col-form-label">
                                    Thumbnail Image<small>(290x300)</small>
                                </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail${i}" data-preview="holder"
                                                class="btn btn-success lfm">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="thumbnail${i}" class="form-control" type="text" name="variants[${i}][thumbnail_image]" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <img id="holder${i}" style="margin-top:15px;max-height:100px;">
                                </div>
                            </div>

                            <div id="img_div${i}">
                                <div class="row mb-3 mt-2">
                                    <label for="lfm" class="col-sm-4 col-form-label">
                                        Image<small>(570x680)</small>
                                    </label>
                                    <div class="col-sm-7 col-10">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="cat_img${j}" data-preview="cat_img_holder${i}"
                                                    class="btn btn-success lfm">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="cat_img${j}" class="form-control" type="text" name="variants[${i}][images][]"
                                                placeholder="Please select image" readonly required>

                                            <div class="invalid-feedback">
                                                Please enter category name.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1 col-2">
                                        <button type="button" class="btn btn-sm btn-info float-end mt-1 new_img" id="new_img${i}"
                                            title="Add new image">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <img id="cat_img_holder${i}" style="margin-top:15px;max-height:100px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $('#product_div').append(variant);

                // Unisharp filemanager for the new variant
                $('.lfm').filemanager('file');

                // Listen for changes in the "cat_img" input field for the new variant
                $('#cat_img' + j).change(function() {
                    var imageUrl = $(this).val();
                    $('#cat_img_holder' + j).attr('src', imageUrl);
                });

                // Listen for changes in the "thumbnail" input field for the new variant
                $('#thumbnail' + i).change(function() {
                    var imageUrl = $(this).val();
                    $('#holder' + i).attr('src', imageUrl);
                });
            });

            // remove variant div dynamically on click of remove button id remove
            $('#product_div').on('click', '.remove', function() {
                var id = $(this).attr('id');
                var split_id = id.split('remove');
                var deleteindex = split_id[1];

                // Remove <div> with id
                $('#variant_div' + deleteindex).remove();
            });

            // Event delegation for "Add new image" button
            $('#product_div').on('click', '.new_img', function() {
                j++;
                // Create a new image HTML
                let newImage = `<div class="row mb-3 mt-2">
                                        <label for="lfm" class="col-sm-4 col-form-label">
                                            Image<small>(570x680)</small>
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="cat_img${j}" data-preview="cat_img_holder"
                                                        class="btn btn-success lfm">
                                                        <i class="fa fa-picture-o"></i> Choose
                                                    </a>
                                                </span>
                                                <input id="cat_img${j}" class="form-control" type="text" name="variants[${i}][images][]"
                                                    placeholder="Please select image" readonly required>

                                                <div class="invalid-feedback">
                                                    Please enter category name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-sm btn-danger float-end mt-1 rmv_img" id="remv_img${j}"
                                                title="Remove image">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <img id="cat_img_holder${j}" style="margin-top:15px;max-height:100px;">
                                        </div>
                                    </div>`;

                // get vcurrect ariant_div id and append to the new image
                var variant_div_id = $(this).closest('.card').attr('id');

                //get id last no from variant_div_id and append to the new image
                var variant_div_id = variant_div_id.slice(-1);

                // Append the new image to the variant_div
                $('#img_div' + variant_div_id).append(newImage);

                // Unisharp filemanager for the new image
                $('.lfm').filemanager('file');

                // Listen for changes in the "cat_img" input field for the new image
                $('#cat_img' + j).change(function() {
                    var imageUrl = $(this).val();
                    $('#cat_img_holder' + j).attr('src', imageUrl);

                    // enable the new image button
                    $('#new_img' + variant_div_id).prop('disabled', false);
                });

                // disabled the new image button
                $('#new_img' + variant_div_id).prop('disabled', true);
            });

            // remove image div dynamically on click of remove button id rmv_img
            $('#product_div').on('click', '.rmv_img', function() {

                var variant_div_id = $(this).closest('.card').attr('id');

                //get id last no from variant_div_id and append to the new image
                var variant_div_id = variant_div_id.slice(-1);

                // Enable the new image button
                $('#new_img' + variant_div_id).prop('disabled', false);

                $(this).closest('.row').remove();
            });
        });
    </script>
@endsection
