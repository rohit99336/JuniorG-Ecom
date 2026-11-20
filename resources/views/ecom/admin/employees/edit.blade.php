@extends('ecom.admin.layouts.app')
@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('ecomadmin.dashboard') }}">Home</a></li>
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

                        <!-- Messgaes -->
                        <div>
                            @if ($errors->any())
                                <ul class="alert">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">
                                            {{ $error }}</li>
                                    @endforeach
                                </ul>
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
                        </div>

                        <form class="row g-3 needs-validation"
                            action="{{ route('ecomadmin.employees.update', $employee->id) }}"
                            method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <label for="name"
                                    class="form-label">Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    id="name" name="name"
                                    value="{{ $employee->name }}" required>
                                <div class="invalid-feedback">
                                    Please enter name.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email"
                                    class="form-label">Email<span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control"
                                    id="email" name="email"
                                    value="{{ $employee->email }}" required>
                                <div class="invalid-feedback">
                                    Please enter email.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone
                                    1<span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    id="phone" name="phone"
                                    value="{{ $employee->phone }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    minlength="10" maxlength="10" required>
                                <div class="invalid-feedback">
                                    Please enter phone.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="phone2" class="form-label">Phone
                                    2</label>
                                <input type="text" class="form-control"
                                    id="phone2" name="phone2"
                                    value="{{ $employee->phone2 }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    minlength="10" maxlength="10">
                                <div class="invalid-feedback">
                                    Please enter phone 2.
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <label for="pa"
                                    class="form-label">Password<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    id="password" name="password"
                                    value="{{ $employee->password ?? old('password') }}"
                                    required>
                                <div class="invalid-feedback">
                                    Please enter password.
                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <label for="address"
                                    class="form-label">Address</label>
                                <textarea class="form-control" name="address" id="address"
                                    rows="01">{{ $employee->address }}</textarea>
                                <div class="invalid-feedback">
                                    Please enter salon address.
                                </div>
                            </div>

                            <div class="col-10" id="variants">
                                <label for="roles">Roles</label>
                                <select class="select2 form-label"
                                    name="roles[]" multiple="multiple"
                                    style="width:100%"
                                    placeholder="select roles">
                                    {{-- @if (!empty($employee->roles)) --}}
                                        @foreach ($roles as $role)
                                            @php
                                                $isSelected = false;
                                            @endphp
                                            @foreach ($employee->roles as $emp_role)
                                                @if ($role->id == $emp_role->id)
                                                    @php
                                                        $isSelected = true;
                                                        break; // Once found, no need to continue looping
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <option
                                                value="{{ $role->name }}"
                                                {{ $isSelected ? 'selected' : '' }}>
                                                {{ ucfirst($role->name ?? '') }}
                                            </option>
                                        @endforeach
                                    {{-- @else
                                        @foreach ($roles as $pro)
                                            <option
                                                value="{{ $pro->id }}">
                                                {{ ucfirst($pro->name ?? '') }}
                                            </option>
                                        @endforeach
                                    @endif --}}

                                </select>
                            </div>

                            <div class="col-2">
                                <div class="form-check mt-4">
                                    <input class="form-check-input"
                                        type="checkbox" id="sel_all_offer"
                                        name="is_sel_all">
                                    <label class="form-check-label"
                                        for="sel_all_offer">
                                        Select All
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary float-end"
                                    type="submit">
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
    <script
        src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}">
    </script>
    <script src="{{ asset('vendor/laravel-filemanager/js/filemanager.js') }}">
    </script>
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

        $(document).ready(function() {
            $(".select2").select2({
                placeholder: "Select a roles", // Placeholder text
                allowClear: true // Optionally allow clearing the selection
            });

            // slecet all services checkbox
            $('#sel_all').click(function() {
                if ($(this).is(':checked')) {
                    $('.offers_s input[type="checkbox"]').prop(
                        'checked', true);
                } else {
                    $('.offers_s input[type="checkbox"]').prop(
                        'checked', false);
                }
            });

            // if all services are selected then select all checkbox will be checked
            $('.offers_s input[type="checkbox"]').click(function() {
                if ($(
                        '.offers_s input[type="checkbox"]:checked'
                    )
                    .length == $(
                        '.offers_s input[type="checkbox"]')
                    .length) {
                    $('#sel_all').prop('checked', true);
                } else {
                    $('#sel_all').prop('checked', false);
                }
            });

            // if select all checkbox is checked then all select2 options will be selected
            $('#sel_all_offer').click(function() {
                if ($(this).is(':checked')) {
                    $('.select2 option').prop('selected',
                        true);
                    $('.select2').trigger('change');
                } else {
                    $('.select2 option').prop('selected',
                        false);
                    $('.select2').trigger('change');
                }
            });

            // if change products select2 options then select all checkbox will be unchecked
            $('.select2').change(function() {
                if ($('.select2 option:selected').length == $(
                        '.select2 option').length) {
                    $('#sel_all_offer').prop('checked', true);
                } else {
                    $('#sel_all_offer').prop('checked', false);
                }
            });
        });
    </script>
@endsection
