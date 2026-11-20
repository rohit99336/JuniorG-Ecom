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

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form class="row g-3 needs-validation" action="{{ route('web-masters.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $master->title ?? '' }}" required>
                                <div class="invalid-feedback">
                                    Please enter title.
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="logo" class="form-label">Logo
                                    <small><b>(550*100)</b></small>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-success">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="logo"
                                        value="{{ $master->logo ?? '' }}" readonly>

                                    {{-- <input type="file" name="logo" id="logo" class="form-control"> --}}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <img id="holder" style="margin-top:15px;max-height:100px;" class="img-fluid mt-4"
                                    src="{{ $master->logo ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ $master->phone ?? '' }}" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="10" maxlength="10">
                                <div class="invalid-feedback">
                                    Please enter phone number.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="whatsapp" class="form-label">Whatsapp number</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                    value="{{ $master->whatsapp ?? '' }}" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="10" maxlength="10">
                                <div class="invalid-feedback">
                                    Please enter whatsapp number.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $master->email ?? '' }}" required>
                                <div class="invalid-feedback">
                                    Please enter email.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="map_link" class="form-label">Map Link</label>
                                <input type="text" class="form-control" id="map_link" name="map_link"
                                    value="{{ $master->map_link ?? '' }}" required>
                                <div class="invalid-feedback">
                                    Please enter map link.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="03" required>{{ $master->address ?? '' }}</textarea>
                                <div class="invalid-feedback">
                                    Please enter address.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="meta_keywords" class="form-label">Meta keywords</label>
                                <textarea class="form-control" name="meta_keywords" id="meta_keywords" cols="30" rows="03" required>{{ $master->meta_keywords ?? '' }}</textarea>
                                <div class="invalid-feedback">
                                    Please enter meta keywords.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="meta_description" class="form-label">Meta description</label>
                                <textarea class="form-control" name="meta_description" id="meta_description" cols="30" rows="03"
                                    required>{{ $master->meta_description ?? '' }}</textarea>
                                <div class="invalid-feedback">
                                    Please enter meta description.
                                </div>
                            </div>


                            <h5 class="mt-5"><b>Social link</b></h5>
                            <div class="col-md-6">
                                <label for="facebook" class="form-label">Facebook link</label>
                                <input type="text" class="form-control" id="facebook" name="facebook"
                                    value="{{ $master->facebook ?? '' }}" required>
                                <div class="invalid-feedback">
                                    Please enter facebook link.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="instagram" class="form-label">Instagram link</label>
                                <input type="text" class="form-control" id="instagram" name="instagram"
                                    value="{{ $master->instagram ?? '' }}">
                                <div class="invalid-feedback">
                                    Please enter instagram link.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="youtube" class="form-label">Youtube link</label>
                                <input type="text" class="form-control" id="youtube" name="youtube"
                                    value="{{ $master->youtube ?? '' }}" required>
                                <div class="invalid-feedback">
                                    Please enter youtube link.
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="twitter" class="form-label">Twitter link</label>
                                <input type="text" class="form-control" id="twitter" name="twitter"
                                    value="{{ $master->twitter ?? '' }}">
                                <div class="invalid-feedback">
                                    Please enter twitter link.
                                </div>
                            </div>

                            <hr>

                            <h5 class="mt-2"><b>Other Setting</b></h5>
                            <div class="col-md-6 mt-2">
                                <label for="appointement_msg_temp_id" class="form-label">Appointment SMS
                                    Template</label>
                                <select name="appointement_msg_temp_id" id="appointement_msg_temp_id"
                                    class="form-select">
                                    <option value="">Select Template</option>
                                    @foreach ($templtaes as $template)
                                        <option value="{{ $template->id }}"
                                            {{ $template->id == $master->appointement_msg_temp_id ? 'selected' : '' }}>
                                            {{ $template->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="appointement_mail_temp_id" class="form-label">Appointment Email
                                    Template</label>
                                <select name="appointement_mail_temp_id" id="appointement_mail_temp_id"
                                    class="form-select">
                                    <option value="">Select Template</option>
                                    @foreach ($Emailtempltes as $template)
                                        <option value="{{ $template->id }}"
                                            {{ $template->id == $master->appointement_mail_temp_id ? 'selected' : '' }}>
                                            {{ $template->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mt-5">
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

            // Listen on change logo input field and show image
            $('#logo').change(function() {
                var imageUrl = URL.createObjectURL(event.target.files[0]);
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
                            '<option value="{{ $master }}">Select State</option>'
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
                            '<option value="{{ $master }}">Select City</option>'
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
