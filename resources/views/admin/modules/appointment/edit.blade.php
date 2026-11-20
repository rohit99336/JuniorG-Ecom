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
                        <h5 class="card-title">Edit salon detail</h5>

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

                        <form class="row g-3 needs-validation" action="{{ route('salons.update', $salon->id) }}"
                            method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="col-md-4">
                                <label for="name" class="form-label">Salon name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $salon->name }}" required>
                                <div class="invalid-feedback">
                                    Please enter salon name.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $salon->email }}">
                                <div class="invalid-feedback">
                                    Please enter email address.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="phone" class="form-label">Phone number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ $salon->phone }}" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="10" maxlength="10">
                                <div class="invalid-feedback">
                                    Please enter phone number for salon.
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ $salon->address }}" required>
                                <div class="invalid-feedback">
                                    Please enter salon address.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="pincode" class="form-label">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode"
                                    value="{{ $salon->pincode }}" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="6" maxlength="6">
                                <div class="invalid-feedback">
                                    Please enter pincode.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="country" class="form-label">Country</label>
                                <select class="select2 form-select" id="country_id" name="country">
                                    <option value="">
                                        Select Country
                                    </option>
                                    @foreach ($coutries as $key => $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == $salon->country ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                    Please select a country.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <select class="select2 form-select" id="state_id" name="state">
                                    @foreach ($states as $key => $state)
                                        <option value="{{ $state->id }}"
                                            {{ $state->id == $salon->state ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please select a state.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <select class="select2 form-select" id="city_id" name="city">
                                    @foreach ($cities as $key => $city)
                                        <option value="{{ $city->id }}"
                                            {{ $city->id == $salon->city ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please select a city.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="03">
                                    {{$salon->description}}
                                </textarea>
                                <div class="invalid-feedback">
                                    Please enter salon description.
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

                            <div class="card-body">
                                <h5 class="card-title">Adding Services to Your New Salon</h5>
                                <p>Welcome to your new salon! To provide excellent customer experiences and make your salon
                                    stand out, it's essential to offer a variety of services that cater to your clients'
                                    needs. Here's how you can add services to your salon:</p>
                                <!-- Active Table -->
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td scope="col">
                                                <h5>All services</h5>
                                            </td>
                                            <td scope="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="sel_all">
                                                    <label class="form-check-label" for="sel_all">
                                                        Select All
                                                    </label>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>

                                        @foreach ($services as $key => $service)
                                            <tr class="service_s">
                                                <td>{{ $service->name }}</td>
                                                <td>
                                                    {{-- <input class="form-check-input" type="checkbox"
                                                        id="gridCheck{{ $key + 1 }}" value="{{ $service->id }}"
                                                        name="services[]" checked> --}}

                                                    {{-- <option value="{{ $lamination->id }}"
                                                            {{ in_array($lamination->id, $module_data->laminations->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                            {{ $lamination->name }}
                                                        </option> --}}
                                                    @php
                                                        $checked = false;
                                                    @endphp
                                                    @foreach ($salon->services as $sal_service)
                                                        @if ($service->id == $sal_service)
                                                            @php
                                                                $checked = true;
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                    <input class="form-check-input" type="checkbox"
                                                        id="gridCheck{{ $key + 1 }}" value="{{ $service->id }}"
                                                        name="services[]" {{ $checked ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <a href="{{ route('services.show', $service->id) }}"
                                                        class="btn btn-success">
                                                        <i class="bx bx-show-alt "></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Active Table -->
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit</button>
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

            // check all services checkbox is checked or not then select all checkbox will be checked
            if ($('.service_s input[type="checkbox"]:checked').length == $(
                    '.service_s input[type="checkbox"]')
                .length) {
                $('#sel_all').prop('checked', true);
            } else {
                $('#sel_all').prop('checked', false);
            }

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
            $('#country_id').on('change', function() {
                var country_id = this.value;
                console.log(country_id + ' Country');
                $("#state_id").html('');
                $.ajax({
                    url: "{{ route('states') }}",
                    type: "GET",
                    data: {
                        country_id: country_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state_id').html(
                            '<option value="">Select State</option>'
                        );
                        $.each(result.states,
                            function(key,
                                value) {
                                $("#state_id")
                                    .append(
                                        '<option value="' +
                                        value
                                        .id +
                                        '">' +
                                        value
                                        .name +
                                        '</option>'
                                    );
                            });
                    }
                });
            });

            // get cities based on state
            $('#state_id').on('change', function() {
                var state_id = this.value;
                $("#city_id").html('');
                $.ajax({
                    url: "{{ route('cities') }}",
                    type: "GET",
                    data: {
                        state_id: state_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city_id').html(
                            '<option value="">Select City</option>'
                        );
                        $.each(result.cities,
                            function(key,
                                value) {
                                $("#city_id")
                                    .append(
                                        '<option value="' +
                                        value
                                        .id +
                                        '">' +
                                        value
                                        .name +
                                        '</option>'
                                    );
                            });
                    }
                });
            });
        });
    </script>
@endsection
