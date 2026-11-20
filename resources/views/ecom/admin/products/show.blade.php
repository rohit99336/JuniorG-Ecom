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
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title">Product information</h5>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('ecomadmin.prod.products.index') }}" class="btn btn-primary mt-3 float-end">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <!-- Product information -->
                <table class="table table-bordered ">
                    <hr>
                    <div class="row m-auto">
                        <div class="col-4">
                            Category - <b>{{ $product->category->name }}</b>
                        </div>
                        <div class="col-4">
                            Product name - <b>{{ $product->name }}</b>
                        </div>
                        <div class="col-4">
                            Status - <b>{{ $product->is_active ? 'Active' : 'Inactive' }}</b>
                        </div>
                    </div>
                    <div class="row m-auto mt-3">
                        <div class="col-4">
                            Is refundable - <b>{{ $product->is_refundable ? 'Yes' : 'No' }}</b>
                        </div>
                        <div class="col-4">
                            Cash on delivory - <b>{{ $product->is_cod ? 'Yes' : 'No' }}</b>
                        </div>
                        <div class="col-4">
                            Is featured - <b>{{ $product->is_featured ? 'Yes' : 'No' }}</b>
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
                        {{-- <div class="col-4 mt-2">
                            Product Name - <b>{{ $product->name }}</b>
                        </div>
                        <div class="col-4 mt-2">
                            Status - <b>{{ $product->is_active ? 'Active' : 'Inactive' }}</b>
                        </div> --}}
                    </div>

                    <hr>

                    <h4> Variants information </h4>
                    <tbody>
                        @foreach ($product->productVariants as $variant)
                            <tr class="">
                                <td>
                                    <div class="row">
                                        <div class="col-md-4"><b>Color</b> - </div>

                                        <div class="col-md-2">
                                            <div
                                                style="width: 30px; height: 30px; background-color:{{ $variant->color->code ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{ $variant->color->name ?? '' }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6"><b>Unit</b> - </div>
                                        <div class="col-md-6">
                                            {{ $variant->unit_size ?? 00 }} {{ $variant->unit->short_name ?? '' }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6"><b>Price</b> - </div>
                                        <div class="col-md-6">
                                            {{ $variant->price ?? 00 }} ₹
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-8"><b>Stock</b> - </div>
                                        <div class="col-md-4">
                                            {{ $variant->quantity ?? 00}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Product information Example -->
            </div>
        </div>
    </section>
@endsection

@section('script')
@endsection
