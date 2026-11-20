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
                        <h5 class="card-title">Stock transaction information
                        </h5>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('ecomadmin.prod.products.index') }}"
                            class="btn btn-primary mt-3 float-end">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <!-- Product information -->
                <table class="table table-bordered ">
                    <hr>
                    <div class="row m-auto">
                        <div class="col-4">
                            Category -
                            <b>{{ $stock->product->category->name }}</b>
                        </div>
                        <div class="col-4">
                            Product name - <b>{{ $stock->product->name }}</b>
                        </div>
                        <div class="col-4">
                            Status -
                            <b>{{ $stock->product->is_active ? 'Active' : 'Inactive' }}</b>
                        </div>
                    </div>
                    <div class="row m-auto mt-3">
                        <div class="col-4">
                            Is refundable -
                            <b>{{ $stock->product->is_refundable ? 'Yes' : 'No' }}</b>
                        </div>
                        <div class="col-4">
                            Cash on delivory -
                            <b>{{ $stock->product->is_cod ? 'Yes' : 'No' }}</b>
                        </div>
                        <div class="col-4">
                            Is featured -
                            <b>{{ $stock->product->is_featured ? 'Yes' : 'No' }}</b>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-md-2">
                                    Description -
                                </div>
                                <div class="col-md-10">
                                    {!! $stock->product->description !!}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-4 mt-2">
                            Product Name - <b>{{ $stock->product->name }}</b>
                        </div>
                        <div class="col-4 mt-2">
                            Status - <b>{{ $stock->product->is_active ? 'Active' : 'Inactive' }}</b>
                        </div> --}}
                    </div>

                    <hr>

                    <h4> Variants information </h4>
                    <tbody>
                        <tr class="">
                            <td>
                                <div class="row">
                                    <div class="col-md-4"><b>Color</b> - </div>

                                    <div class="col-md-2">
                                        <div
                                            style="width: 30px; height: 30px; background-color:{{ $stock->productVariant->color->code ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $stock->productVariant->color->name ?? '' }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6"><b>Unit</b> - </div>
                                    <div class="col-md-6">
                                        {{ $stock->productVariant->unit_size ?? 00 }}
                                        {{ $stock->productVariant->unit->short_name ?? '' }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6"><b>Price</b> - </div>
                                    <div class="col-md-6">
                                        {{ $stock->productVariant->price ?? 00 }}
                                        ₹
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-8"><b>Stock</b> - </div>
                                    <div class="col-md-4">
                                        {{ $stock->productVariant->quantity ?? 00 }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
                <!-- End Product information Example -->

                <div class="detail mt-3">
                    <h4>Transaction Detail</h4>

                    <div class="row m-auto">
                        <div class="col-6">
                            Transaction by -
                            <b>{{ ucfirst($stock->exportBy->name) }}</b>
                        </div>
                        <div class="col-6">
                            Transaction Type -
                            <b>{{ ucfirst($stock->type) }}</b>
                        </div>
                        <div class="col-6">
                            Transaction Date -
                            <b>{{ date('d-m-Y', strtotime($stock->created_at)) }}</b>
                        </div>

                        <div class="col-6">
                            Old Stock - <b>{{ $stock->old_sctock }}</b>
                        </div>
                        <div class="col-6">
                            Current Stock -
                            <b>{{ $stock->current_sctock }}</b>
                        </div>
                        <div class="col-6">
                            Quantity - <b>{{ $stock->quantity }}</b>
                        </div>
                    </div>
                    <br>

                    <div class="row m-auto">
                        <div class="col-6">
                            Name - <b>{{ ucfirst($stock->name) ?? 'NA' }}</b>
                        </div>
                        <div class="col-6">
                            Email - <b>{{ $stock->email ?? 'NA' }}</b>
                        </div>
                        <div class="col-6">
                            Pincode - <b>{{ $stock->pincode ?? 'NA' }}</b>
                        </div>
                        <div class="col-12">
                            Address - <b>{{ $stock->address ?? 'NA' }}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
@endsection
