@extends('ecom.web.layouts.app')

@section('meta')
    <title>Junior-G - Baby Products Login</title>
    <meta name="description"
        content="Log in to your Junior-G account to access exclusive offers and manage your baby product orders. Explore our delightful range of baby clothing, accessories, toys, and essentials.">
    <meta name="keywords"
        content="Junior-G, baby products login, baby account, baby products access, baby login, baby essentials login">
@endsection

@section('styles')
@endsection

@section('content')
    <main id="MainContent" class="content-for-layout">
        <div class="login-page mt-70">
            <div class="container">
                <div class="login-form common-form mx-auto">
                    <div class="section-header mb-3">
                        <h2 class="section-heading text-center">Login</h2>
                    </div>

                    @include('ecom.web.layouts.messages')

                    <ul class="nav nav-tabs mb-3" id="loginTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="emailTab" data-bs-toggle="tab" data-bs-target="#emailLogin" type="button" role="tab" aria-controls="emailLogin" aria-selected="false">Login with Email</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="phoneTab" data-bs-toggle="tab" data-bs-target="#phoneLogin" type="button" role="tab" aria-controls="phoneLogin" aria-selected="true">Login with Mobile</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="loginTabContent">
                        {{-- <div class="alert alert-danger" id="error" style="display: none"></div>
                        <div class="alert alert-success" id="sentSuccess" style="display: none"></div> --}}

                        <!-- Email/Login Form -->
                        <div class="tab-pane fade" id="emailLogin" role="tabpanel" aria-labelledby="emailTab">
                            <form action="{{ route('shop.postLogin') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="col-12 mt-3 text-center">
                                    <button type="submit" class="btn btn-primary btn-block">SIGN IN</button>
                                    <span class="my-2 d-block">OR</span>
                                    <a href="{{ route('shop.auth.google') }}" class="btn btn-block btn-signin border">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#db4437" class="bi bi-google" viewBox="0 0 16 16">
                                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                                        </svg>
                                        <span class="ml-2">Signup with Google</span>
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Mobile/Login Form -->
                        <div class="tab-pane fade show active" id="phoneLogin" role="tabpanel" aria-labelledby="phoneTab">
                            <div id="sendSms">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Mobile Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your 10 digit mobile number" oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="(6|7|8|9)\d{9}" value="{{ old('phone') }}" minlength="10" maxlength="10" required>
                                </div>
                                <div id="recaptcha-container" class="my-2"></div>
                                <div class="col-12 mt-3 text-center">
                                    <button type="button" class="btn btn-primary btn-block" id="findUser" onclick="phoneSendAuth();">SEND OTP</button>
                                    <span class="my-2 d-block">OR</span>
                                    <a href="{{ route('shop.auth.google') }}" class="btn btn-block btn-signin border">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#db4437" class="bi bi-google" viewBox="0 0 16 16">
                                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                                        </svg>
                                        <span class="ml-2">Signup with Google</span>
                                    </a>
                                </div>
                            </div>
                            <div id="verification" style="display: none;">
                                <div class="mb-3">
                                    <label for="verificationCode" class="form-label">Verification Code</label>
                                    <input type="tel" class="form-control" id="verificationCode" name="verificationCode" placeholder="Enter your OTP" oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="\d{6}" minlength="6" maxlength="6" required>
                                </div>
                                <button type="button" class="btn btn-primary btn-block" onclick="codeverify();">VERIFY</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js">
    </script>


    <script>
        $(document).ready(function() {
            // Empty the value of the input field with ID 'phone' when the page loads
            $('#phone').val('');
            $('#verificationCode').val('');

            // $('#findUser').prop('disabled',
            //     true);

            $('#verification').hide();

            $('#sentSuccess').hide();
            $('#error').hide();

        });
    </script>

    <script>
        var firebaseConfig = {
            apiKey: "",
            authDomain: "juniorg-434bd.firebaseapp.com",
            projectId: "juniorg-434bd",
            storageBucket: "juniorg-434bd.appspot.com",
            messagingSenderId: "957991359833",
            appId: "1:957991359833:web:",
            measurementId: "G-7426LEG1R5"
        };

        firebase.initializeApp(firebaseConfig);
    </script>

    <script type="text/javascript">
        window.onload = function() {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
                'recaptcha-container');
            recaptchaVerifier.render();
        }


        function phoneSendAuth() {
            var number = $("#phone").val();
            var user_number = $("#phone").val();

            // add +91 to the number
            number = "+91" + number;

            $('#sendSms').hide();
            $('#verification').show();

            firebase.auth().signInWithPhoneNumber(number, window
                .recaptchaVerifier).then(function(confirmationResult) {

                // console.log(confirmationResult);
                window.confirmationResult = confirmationResult;

                coderesult = confirmationResult;

                // console.log(coderesult);


                // $("#sentSuccess").text("OTP Sent Successfully.");
                // $("#sentSuccess").show();

                toastr.success('OTP Sent Successfully.');
            }).catch(function(error) {
                // $("#error").text(error.message);
                // $("#error").show();

                toastr.error(error.message);
            });

        }


        function codeverify() {
            var code = $("#verificationCode").val();

            coderesult.confirm(code)
                .then(function(result) {
                    var user = result.user;
                    var phoneNumber = user.phoneNumber;
                    var otp = code;

                    // // Store OTP in localStorage
                    // localStorage.setItem('phoneNumber', phoneNumber);
                    // localStorage.setItem('otp', otp);

                    // alert("OTP verified and stored locally");

                    // Make AJAX request to server
                    $.ajax({
                        url: "{{ route('shop.loginWithOtp') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            phone: phoneNumber,
                            otp: otp
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.statusCode == 200) {
                                // Redirect user upon successful login
                                window.location.href = response
                                    .redirectRoute;
                            } else if (response.error) {
                                // Display error message from server
                                // $('#error').text(response
                                //     .error);
                                // $('#error').show();
                                // setTimeout(function() {
                                //     $('#error').hide();
                                // }, 5000);

                                toastr.error(response.error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);

                            // // Display error message for AJAX request failure
                            // $('#error').text(
                            //     'An error occurred while processing your request.'
                            //     );
                            // $('#error').show();

                            toastr.error('An error occurred while processing your request.');
                        }
                    });

                    // $("#sentSuccess").text(
                    //     "You are registered successfully.");
                    // $("#sentSuccess").show();
                })
                .catch(function(error) {
                    $("#error").text(error.message);
                    $("#error").show();
                });
        }
    </script>

    {{-- <script>
        $('#phone').on('change', function() {
            // Retrieve input values
            var phone = $(this).val();


            // Make AJAX request to find customer by phone number
            $.ajax({
                url: "{{ route('shop.findCustomerByPhone', ':phone') }}"
                    .replace(':phone', phone),
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.statusCode == 200) {
                        // Enable the findUser button if customer is found
                        // $('#findUser').prop('disabled',
                        //     false);

                        // // Display success message
                        // $('#sentSuccess').text(
                        //     'Customer found successfully.'
                        // );
                        // $('#sentSuccess').show(); // Show success message

                        setTimeout(function() {
                            $('#sentSuccess').hide(
                                1);
                        }, 5000);

                        // Hide error message if shown
                        $('#error').hide();
                    } else if (response.error) {
                        // Display error message
                        $('#error').text(response.error);
                        $('#error')
                            .show(); // Show error message

                        $('#error').show();
                        setTimeout(function() {
                            $('#error').hide(1);
                        }, 5000);

                        // $('#findUser').prop('disabled',
                        //     true);

                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);

                    // Display error message for AJAX request failure
                    $('#error').text(
                        'An error occurred while processing your request.'
                    );
                    $('#error')
                        .show(); // Show error message

                    // // Scroll to the error message
                    // $('html, body').animate({
                    //     scrollTop: $('#error')
                    //         .offset().top
                    // }, 500);

                    // $('#findUser').prop('disabled',
                    //     true);
                }

            });
        });
    </script> --}}
@endsection
