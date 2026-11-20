@extends('ecom.admin.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('ecomadmin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $subTitle }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $subTitle }}</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    aria-label="Close">
                                    {{-- <span aria-hidden="true">&times;</span> --}}
                                </button>

                                <strong>Error!</strong> Please fix the following issues:
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="row g-3 needs-validation" action="{{ route('ecomadmin.offers.update', $offer->id) }}"
                            method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="name"
                                    value="{{ $offer->name }}" required>
                                <div class="invalid-feedback">
                                    Please enter title.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="offer_code" class="form-label">Offer code</label>
                                <input type="text" class="form-control" id="offer_code" name="offer_code"
                                    value="{{ $offer->offer_code }}" required>
                                <div class="invalid-feedback">
                                    Please enter offer code.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="offer_type" class="col-form-label">Discount type</label>
                                <select name="offer_type" class="form-select" id="offer_type" required>
                                    <option value="">Select discount type</option>
                                    <option value="percentage" {{ $offer->offer_type == 'percentage' ? 'selected' : '' }}>
                                        Percentage
                                    </option>
                                    <option value="fixed" {{ $offer->offer_type == 'fixed' ? 'selected' : '' }}>Fixed
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="offer_value" class="col-form-label">
                                    Discount value
                                </label>
                                <input type="text" class="form-control" id="offer_value" name="offer_value"
                                    value="{{ $offer->offer_value }}" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="10" maxlength="10">
                                <div class="invalid-feedback">
                                    Please enter discount value.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="valid_from" class="form-label">
                                    Valid from
                                </label>
                                <input type="datetime-local" name="offer_start_time" class="form-control" id="valid_from"
                                    value="{{ $offer->offer_start_time }}" required>
                                <div class="invalid-feedback">
                                    Please select valid from date.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="valid_to" class="form-label">
                                    Valid to
                                </label>
                                <input type="datetime-local" name="offer_end_time" class="form-control" id="valid_to"
                                    value="{{ $offer->offer_end_time }}" required>
                                <div class="invalid-feedback">
                                    Please select valid to date.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="03" required>{{ $offer->description }}</textarea>
                                <div class="invalid-feedback">
                                    Please enter salon description.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="terms" class="form-label">Terms</label>
                                <textarea class="form-control" name="terms" id="terms" cols="30" rows="03" required>{{ $offer->terms }}</textarea>
                                <div class="invalid-feedback">
                                    Please enter salon terms.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="image" class="form-label">Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-success">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="image"
                                        value="{{ $offer->image }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <img src="{{ $offer->image }}" id="holder" style="margin-top:15px;max-height:100px;">
                            </div>
                            <div class="col-10" id="variants">
                                <label for="products">Products</label>
                                <select class="select2 form-label" name="variant_ids[]" multiple="multiple" id="products"
                                    style="width:100%">
                                    @foreach ($products as $pro)
                                        @php
                                            $isSelected = false;
                                        @endphp
                                        @foreach ($offer->offerItems as $offerItem)
                                            @if ($pro->id == $offerItem->product_variant_id)
                                                @php
                                                    $isSelected = true;
                                                    break; // Once found, no need to continue looping
                                                @endphp
                                            @endif
                                        @endforeach
                                        <option value="{{ $pro->id }}" {{ $isSelected ? 'selected' : '' }}>
                                            {{ $pro->product->name }} - {{ $pro->unit_size }}
                                            {{ $pro->unit->short_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-2">
                                @php
                                    if ($offer->is_sel_all == 'on') {
                                        $isSelAll = 'checked';
                                    } else {
                                        $isSelAll = '';
                                    }
                                @endphp
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="sel_all_offer" name="is_sel_all" {{ $isSelAll }}>
                                    <label class="form-check-label" for="sel_all_offer">
                                        Select All
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary float-end" type="submit">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

            $('#lfm').filemanager('file');

            // Listen for changes in the "thumbnail" input field
            $('#thumbnail').change(function() {
                var imageUrl = $(this).val();
                $('#holder').attr('src', imageUrl);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("valid_from")[0].setAttribute('min', today);
            document.getElementsByName("valid_to")[0].setAttribute('min', today);

            // validate valid from date and valid to date
            $('#valid_to').change(function() {
                var valid_to = $(this).val();
                var valid_from = $('#valid_from').val();

                if (valid_from > valid_to) {
                    alert('Valid to date should be greater than valid from date');
                    $('#valid_to').val('');
                } else if (valid_from == valid_to) {
                    alert('Valid to date should be greater than valid from date');
                    $('#valid_to').val('');
                } else {
                    document.getElementsByName("valid_from")[0].setAttribute('max', valid_to);

                    var today = new Date().toISOString().split('T')[0];
                    document.getElementsByName("valid_from")[0].setAttribute('min', valid_from);
                }

                // else{
                //     var today = new Date().toISOString().split('T')[0];
                //     document.getElementsByName("valid_from")[0].setAttribute('min', valid_from);
                // }
            });
            $('#valid_from').change(function() {
                var valid_from = $(this).val();
                var valid_to = $('#valid_to').val();

                if (valid_to != '') {
                    if (valid_from > valid_to) {
                        alert('Valid to date should be greater than valid from date');
                        $('#valid_to').val('');
                    }
                } else {
                    var today = new Date().toISOString().split('T')[0];
                    document.getElementsByName("valid_to")[0].setAttribute('min', valid_from);

                    document.getElementsByName("valid_from")[0].setAttribute('max', today);
                }
            });

            // if discount_type is percentage then discount should be less than 100
            $('#discount_type').change(function() {
                var discount_type = $(this).val();
                var discount = $('#discount').val();

                if (discount_type == 'percentage') {

                    // set max length of discount to 2
                    $('#discount').attr('maxlength', '2');

                    if (discount > 100) {
                        alert('Discount should be less than 100');
                        $('#discount').val('');
                    }
                } else {
                    $('#discount').attr('maxlength', '10');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // $(".select2").select2({
            //     theme: "bootstrap-5",
            //     width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
            //         'style',
            //     placeholder: $(this).data('placeholder'),
            //     // allowClear: true
            // });

            $(".select2").select2();

            // slecet all services checkbox
            $('#sel_all').click(function() {
                if ($(this).is(':checked')) {
                    $('.offers_s input[type="checkbox"]').prop('checked', true);
                } else {
                    $('.offers_s input[type="checkbox"]').prop('checked', false);
                }
            });

            // if all services are selected then select all checkbox will be checked
            $('.offers_s input[type="checkbox"]').click(function() {
                if ($('.offers_s input[type="checkbox"]:checked').length == $(
                        '.offers_s input[type="checkbox"]')
                    .length) {
                    $('#sel_all').prop('checked', true);
                } else {
                    $('#sel_all').prop('checked', false);
                }
            });

            //============================================================================//
            //                                                                            //
            //============================================================================//

            // if select all checkbox is checked then all select2 options will be selected
            $('#sel_all_offer').click(function() {
                if ($(this).is(':checked')) {
                    $('.select2 option').prop('selected', true);
                    $('.select2').trigger('change');
                } else {
                    $('.select2 option').prop('selected', false);
                    $('.select2').trigger('change');
                }
            });

            // if change products select2 options then select all checkbox will be unchecked
            $('.select2').change(function() {
                if ($('.select2 option:selected').length == $('.select2 option').length) {
                    $('#sel_all_offer').prop('checked', true);
                } else {
                    $('#sel_all_offer').prop('checked', false);
                }
            });
        });

        $(document).ready(function() {
            var route = "{{ route('ecomadmin.getProducts') }}";
            $.ajax({
                url: route,
                type: "GET",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {

                    $('#for_service').show();
                    $.each(result.products,
                        function(key, value) {
                            $("#offers_s")
                                .append(
                                    `<tr class="offers_s" >
                                        <td>${value.name}</td>
                                        <td>${value.unit_size} ${value.unit.short_name}</td>
                                        <td>${value.color.name}</td>
                                        <td>
                                            <input class="form-check-input" type="checkbox"
                                                id="gridCheck ${value.id}" value="${value.id}"
                                                name="services[]" checked>
                                        </td>
                                    </tr>`
                                );
                        });
                }
            });
        });
    </script>
@endsection
