@extends('admin.layouts.app')


@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('ecomadmin.dashboard')}}">Home</a></li>
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

                        <form class="row g-3 needs-validation" action="{{ route('offers.store') }}" method="POST"
                            novalidate>
                            @csrf

                            <div class="col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title') }}" required>
                                <div class="invalid-feedback">
                                    Please enter title.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">For</label>
                                <select class="form-select" name="type" id="type">
                                    <option value="">Select service type</option>
                                    <option value="service">Service</option>
                                    <option value="course">Course</option>
                                </select>
                            </div>

                            {{-- <div class="col-md-6" id="for_service" style="display: none">
                            </div> --}}

                            <div class="col-md-6">
                                <label for="discount_type" class="col-form-label">Discount Type</label>
                                <select name="discount_type" class="form-select" id="discount_type" required>
                                    <option value="">Select discount type</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="flat">Flat</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="discount" class="col-form-label">
                                    Offer Price/Percentage
                                </label>
                                <input type="text" class="form-control" id="discount" name="discount"
                                    value="{{ old('discount') }}" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="10" maxlength="10">
                                <div class="invalid-feedback">
                                    Please enter offer price.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="valid_from" class="form-label">
                                    Valid From
                                </label>
                                <input type="datetime-local" name="valid_from" class="form-control" id="valid_from"
                                    required>
                                <div class="invalid-feedback">
                                    Please select valid from date.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="valid_to" class="form-label">
                                    Valid To
                                </label>
                                <input type="datetime-local" name="valid_to" class="form-control" id="valid_to" required>
                                <div class="invalid-feedback">
                                    Please select valid to date.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="03" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter salon description.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="terms" class="form-label">Terms</label>
                                <textarea class="form-control" name="terms" id="terms" cols="30" rows="03" required></textarea>
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
                                    <input id="thumbnail" class="form-control" type="text" name="image" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img id="holder" style="margin-top:15px;max-height:100px;">
                            </div>

                            <div class="card-body" id="for_service" style="display: none">
                                <h5 class="card-title">
                                    Introducing Exciting New Offers at Your Salon
                                </h5>
                                <p>
                                    Welcome to the world of rejuvenation and beauty! To make your salon a go-to destination
                                    for clients and to keep them excited, you should introduce a range of enticing offers
                                    that cater to their desires. Here's how you can introduce new offers at your salon:
                                </p>


                                <table class="table">
                                    <tbody id="service_s">
                                        <tr>
                                            <td scope="col">
                                                <h5 id="ser_header">All services</h5>
                                            </td>
                                            <td scope="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="sel_all" checked>
                                                    <label class="form-check-label" for="sel_all">
                                                        Select All
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- End Active Table -->
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary float-end" type="submit">Submit</button>
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
            $(".select2").select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                // allowClear: true
            });

            // slecet all services checkbox
            $('#sel_all').click(function() {
                if ($(this).is(':checked')) {
                    $('.service_s input[type="checkbox"]').prop('checked', true);
                } else {
                    $('.service_s input[type="checkbox"]').prop('checked', false);
                }
            });

            // if all services are selected then select all checkbox will be checked
            $('.service_s input[type="checkbox"]').click(function() {
                if ($('.service_s input[type="checkbox"]:checked').length == $(
                        '.service_s input[type="checkbox"]')
                    .length) {
                    $('#sel_all').prop('checked', true);
                } else {
                    $('#sel_all').prop('checked', false);
                }
            });
        });

        $(document).ready(function() {
            // get states based on country
            $('#type').on('change', function() {
                var type = this.value;

                if (type == 'service') {
                    var route = "{{ route('get-service-variants') }}";
                } else if (type == 'course') {
                    var route = "{{ route('get-courses') }}";
                }

                // empty service_s table
                $('#service_s').html('');


                $.ajax({
                    url: route,
                    type: "GET",
                    data: {
                        type: type,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);

                        if (type == 'service') {
                            // show for_service and create service options
                            $('#for_service').show();
                            $.each(result.service,
                                function(key, value) {
                                    $("#service_s")
                                        .append(
                                            `<tr class="service_s" >
                                                <td>${value.name}</td>
                                                <td>
                                                    <input class="form-check-input" type="checkbox"
                                                        id="gridCheck ${value.id}" value="${value.id}"
                                                        name="services[]" checked>
                                                </td>
                                            </tr>`
                                        );
                                });

                        } else if (type == 'course') {
                            $('#for_service').show();
                            $('#ser_header').html('All courses');
                            $.each(result.course,
                                function(key, value) {
                                    $("#service_s")
                                        .append(
                                            `<tr class="service_s" >
                                                <td>${value.name}</td>
                                                <td>
                                                    <input class="form-check-input" type="checkbox"
                                                        id="gridCheck ${value.id}" value="${value.id}"
                                                        name="services[]" checked>
                                                </td>
                                            </tr>`
                                        );
                                });
                        }
                    }
                });
            });

            // // get cities based on state
            // $('#state_id').on('change', function() {
            //     var state_id = this.value;
            //     $("#city_id").html('');
            //     $.ajax({
            //         url: "{{ route('cities') }}",
            //         type: "GET",
            //         data: {
            //             state_id: state_id,
            //             _token: '{{ csrf_token() }}'
            //         },
            //         dataType: 'json',
            //         success: function(result) {
            //             $('#city_id').html(
            //                 '<option value="">Select City</option>'
            //             );
            //             $.each(result.cities,
            //                 function(key,
            //                     value) {
            //                     $("#city_id")
            //                         .append(
            //                             '<option value="' +
            //                             value
            //                             .id +
            //                             '">' +
            //                             value
            //                             .name +
            //                             '</option>'
            //                         );
            //                 });
            //         }
            //     });
            // });
        });
    </script>
@endsection
