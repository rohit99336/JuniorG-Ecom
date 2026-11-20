@extends('ecom.admin.layouts.app')

@section('content')
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

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title">Add New Stock</h5>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('ecomadmin.prod.products.index') }}"
                            class="btn btn-primary mt-3 float-end">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <form class="row g-3 needs-validation mt-2"
                    action="{{ route('ecomadmin.prod.store-stock') }}"
                    method="POST" novalidate>
                    @csrf

                    <table class="table table-bordered ">
                        <hr>
                        <div class="row m-auto">
                            <div class="col-4">
                                Category -
                                <b>{{ $product->category->name }}</b>
                            </div>
                            <div class="col-4">
                                Product name - <b>{{ $product->name }}</b>
                            </div>
                            <div class="col-4">
                                Status -
                                <b>{{ $product->is_active ? 'Active' : 'Inactive' }}</b>
                            </div>
                        </div>
                        <div class="row m-auto mt-3">
                            <div class="col-4">
                                Is refundable -
                                <b>{{ $product->is_refundable ? 'Yes' : 'No' }}</b>
                            </div>
                            <div class="col-4">
                                Cash on delivory -
                                <b>{{ $product->is_cod ? 'Yes' : 'No' }}</b>
                            </div>
                            <div class="col-4">
                                Is featured -
                                <b>{{ $product->is_featured ? 'Yes' : 'No' }}</b>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-md-2">
                                        Description -
                                    </div>
                                    <div class="col-md-10">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>


                        <h4> Variants information </h4>
                        <thead>
                            <th>Color</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Current Stock</th>
                            <th>New Stock</th>
                        </thead>
                        <tbody>


                            <input type="hidden" name="product_id"
                                value="{{ $product->id }}">
                            @foreach ($product->productVariants as $varkey => $variant)
                                <tr class="">
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div
                                                    style="width: 30px; height: 30px; background-color:{{ $variant->color->code ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{ $variant->color->name ?? 'NA' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $variant->unit_size ?? 00 }}
                                        {{ $variant->unit->short_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $variant->price ?? 00 }} ₹
                                    </td>
                                    <td>
                                        {{ $variant->quantity ?? 00 }}
                                    </td>
                                    <td>
                                        <input type="hidden"
                                            class="form-control"
                                            id="variant_id{{ $varkey + 1 }}"
                                            name="variants[{{ $varkey + 1 }}][variant_id]"
                                            value="{{ $variant->id }}">

                                        <input type="hidden"
                                            class="form-control"
                                            id="type{{ $varkey + 1 }}"
                                            name="variants[{{ $varkey + 1 }}][type]"
                                            value="import">

                                        <input type="hidden"
                                            class="form-control"
                                            id="price{{ $varkey + 1 }}"
                                            name="variants[{{ $varkey + 1 }}][price]"
                                            value="{{ $variant->price }}">

                                        <input type="text"
                                            class="form-control"
                                            id="quantity{{ $varkey + 1 }}"
                                            name="variants[{{ $varkey + 1 }}][quantity]"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            minlength="1"
                                            value="{{ $variant->quantity }}"
                                            placeholder="1" required>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <button type="submit"
                                class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        });
    </script>
@endsection
