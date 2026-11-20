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
                        <h5 class="card-title">Export Stock</h5>
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
                            <th>Out Stock</th>
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
                                            value="export">

                                        <input type="hidden"
                                            class="form-control"
                                            id="price{{ $varkey + 1 }}"
                                            name="variants[{{ $varkey + 1 }}][price]"
                                            value="{{ $variant->price }}">


                                        <input type="text"
                                            class="form-control quantityInput"
                                            autofocus
                                            id="quantity{{ $varkey + 1 }}"
                                            name="variants[{{ $varkey + 1 }}][quantity]"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            minlength="1"
                                            data-correct_stock="{{ $variant->quantity }}"
                                            value="{{ $variant->quantity }}"
                                            placeholder="1" required>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr>

                    <div class="card-body">
                        <h4 class="mb-3">Export To</h4>
                        <div class="row mb-3">
                            <div class="col-md-6 mt-2">
                                <label for="name">Name</label>

                                <input type="text" class="form-control"
                                    id="name" name="name"
                                    value="{{ old('name') }}" required>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone"
                                    class="form-control"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    pattern="(6|7|8|9)\d{9}"
                                    value="{{ old('phone') }}" minlength="10"
                                    maxlength="10" placeholder="987654321"
                                    required />
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="email">Email</label>

                                <input type="text" class="form-control"
                                    id="email" name="email"
                                    value="{{ old('email') }}" required>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control"
                                    id="pincode" name="pincode" oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="6" maxlength="6"
                                    value="{{ old('pincode') }}" required>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="address">Address</label>

                                <input type="text" class="form-control"
                                    id="address" name="address"
                                    value="{{ old('address') }}" required>
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <button type="submit"
                                    class="btn btn-primary">Submit</button>
                            </div>
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

    <script>
        $(document).ready(function() {
            $('.quantityInput').on('change', function() {
                var enteredQuantity = parseInt($(this).val());
                var currentStock = parseInt($(this).data(
                    'correct_stock'));

                if (enteredQuantity > currentStock) {
                    alert(
                        'Entered quantity cannot be greater than current stock.');
                    // Reset the input value to the current stock
                    $(this).val(currentStock);
                }
            });
        });
    </script>
@endsection
