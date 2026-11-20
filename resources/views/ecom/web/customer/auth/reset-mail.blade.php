<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Password Reset Request</title>
    <meta name="description" content="Password Reset Request.">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <!-- 100% body table -->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <img src="{{ asset('ecom/images/final logo shrivenu.png') }}" alt="Shrivenu Salon"
                                style="max-height: 150px; max-width:200px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px; background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        {{-- <h1
                                            style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;">
                                            Registration Confirmation
                                        </h1> --}}
                                        <p style="font-size:15px; color:#455056; margin:8px 0 0; line-height:24px;">
                                            Dear {{ $data['name'] }},
                                            {{-- Dear [User], --}}
                                        </p>

                                        <p>
                                            You are receiving this email because we received a request to reset the
                                            password for your Juniorg account. If you did not make this
                                            request, please disregard this email.
                                            <br>

                                            To reset your password, click on the following link:
                                            <br>
                                            {{-- <a href="{{ $data['reset_link'] }}"
                                                style="background: #4E5E6E; text-decoration: none; color: #fff; padding: 10px 20px; border-radius: 5px; margin: 20px 0; display: inline-block;">Reset
                                                Password</a>
                                            <br> --}}

                                            {{-- <a href="#"
                                                style="background: #4E5E6E; text-decoration: none; color: #fff; padding: 10px 20px; border-radius: 5px; margin: 20px 0; display: inline-block;">Reset
                                                Password</a> --}}

                                        <form action="{{ route('shop.resetpassword', $data['token']) }}" method="get" target="_blank">
                                            @csrf
                                            <input type="hidden" name="email" value="{{ $data['email'] }}">
                                            <input type="hidden" name="token" value="{{ $data['token'] }}">
                                            <input type="hidden" name="name" value="{{ $data['name'] }}">
                                            {{-- <input type="hidden" name="reset_link" value="{{ $data['reset_link'] }}"> --}}
                                            <button type="submit"
                                                style="background: #4E5E6E; text-decoration: none; color: #fff; padding: 10px 20px; border-radius: 5px; margin: 20px 0; display: inline-block;">
                                                Reset Password
                                            </button>
                                        </form>
                                        <br>

                                        <br>
                                        <br>
                                        If you encounter any issues or need further assistance, please don't hesitate to
                                        contact our support team.
                                        </p>

                                        <p style="text-align: left;">
                                            Best regards,
                                            <br>
                                            Juniorg Team
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <a href="https://shrivenunaturals.com/shop" style="text-decoration: none" target="_blank">
                                <p
                                    style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                    &copy; <strong>www.shrivenunaturals.com</strong>
                                </p>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>
