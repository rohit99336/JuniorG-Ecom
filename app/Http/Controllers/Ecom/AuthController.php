<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\EcomAdmin;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating EcomAdmins  for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect EcomAdmins  after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/login';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('guest:ecomadmin', ['except' => ['ecomLogout']]);
    }


    /**
     * Login Page
     */
    public function showLoginForm()
    {
        $user = auth()->guard('ecomadmin')->user();
        return view('ecom.admin.auth.login');
    }


    /**
     * Login a new EcomAdmin instance after a valid login.
     *
     * @request POST
     */
    protected function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|min:6'
            ]);

            // return all errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // remember me using cookies
            if ($request->remember === null) {
                setcookie('email', $request->email, 100);
                setcookie('password', $request->password, 100);
            } else {
                setcookie('email', $request->email, time() + 60 * 60 * 24 * 100);
                setcookie('password', $request->password, time() + 60 * 60 * 24 * 100);
            }

            // attempt to login
            if (Auth::guard('ecomadmin')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                session()->put('user', Auth::guard('ecomadmin')->user());
                return redirect()->route('ecomadmin.dashboard');
            } else {
                Log::error($request->email . " has failed to login.");
                session()->flash('error', 'Invalid Credentials');
                return redirect()->back()->withInput($request->only('email', 'password'));
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Logout a new EcomAdmin instance after a valid login.
     *
     * @request POST
     */
    protected function ecomLogout(Request $request)
    {
        try {
            // Auth::guard('ecomadmin')->logout();

            // destroy all session
            Auth::guard('ecomadmin')->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect()->route('ecomLogin');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Logout user from all devices
     */
    public function logoutAllDevices(Request $request)
    {
        try {
            $EcomAdmin = EcomAdmin::where('id', Auth::guard('ecomadmin')->user()->id)->first();
            if ($EcomAdmin) {
                $EcomAdmin->tokens()->delete();
                return redirect()->back()->with('success', 'Logout from all devices successfully');
            } else {
                return redirect()->back()->with('error', 'Invalid Token');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Logout user from current device
     */
    public function logoutCurrentDevice(Request $request)
    {
        try {
            $EcomAdmin = EcomAdmin::where('id', Auth::guard('ecomadmin')->user()->id)->first();
            if ($EcomAdmin) {
                $EcomAdmin->currentAccessToken()->delete();
                return redirect()->back()->with('success', 'Logout from current device successfully');
            } else {
                return redirect()->back()->with('error', 'Invalid Token');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }


    /**
     * Logout and Go to user dashboard
     */
    public function goToEcom(Request $request)
    {
        try {
            Auth::guard('web')->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect()->route('ecomadmin.dashboard');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('ecomLogin')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Forgot Password Page
     */
    public function showForgotPasswordForm()
    {
        return view('web.auth.forgot-password');
    }

    /**
     * Forgot Password
     */
    public function forgotPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
            ]);

            // return all errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $EcomAdmin = EcomAdmin::where('email', $request->email)->first();
            if ($EcomAdmin) {
                $token = Str::random(60);
                $EcomAdmin->password_reset_token = $token;
                $EcomAdmin->password_reset_at = Carbon::now();
                $EcomAdmin->save();

                $data = [
                    'name' => $EcomAdmin->name,
                    'email' => $EcomAdmin->email,
                    'token' => $token,
                ];

                Mail::send('web.auth.emails.forgot-password', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'], $data['name'])->subject('Reset Password');
                    // $message->from(' ', ' ');
                });

                return redirect()->back()->with('success', 'Reset Password Link Sent to Your Email');
            } else {
                return redirect()->back()->with('error', 'Email Not Found');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Reset Password Page
     */
    public function showResetPasswordForm($token)
    {
        $EcomAdmin = EcomAdmin::where('password_reset_token', $token)->first();
        if ($EcomAdmin) {
            return view('web.auth.reset-password', compact('EcomAdmin'));
        } else {
            return redirect()->route('login')->with('error', 'Invalid Token');
        }
    }


    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6|same:password',
            ]);

            // return all errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $EcomAdmin = EcomAdmin::where('password_reset_token', $request->token)->first();
            if ($EcomAdmin) {
                $EcomAdmin->password = Hash::make($request->password);
                $EcomAdmin->password_reset_token = null;
                $EcomAdmin->password_reset_at = null;
                $EcomAdmin->save();

                return redirect()->route('login')->with('success', 'Password Reset Successfully');
            } else {
                return redirect()->route('login')->with('error', 'Invalid Token');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Change Password Page
     */
    public function showChangePasswordForm()
    {
        return view('EcomAdmin.auth.change-password');
    }

    /**
     * Change Password
     */
    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|min:6',
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6|same:password',
            ]);

            // return all errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $EcomAdmin = EcomAdmin::where('id', Auth::guard('ecomadmin')->user()->id)->first();
            if ($EcomAdmin) {
                if (Hash::check($request->old_password, $EcomAdmin->password)) {
                    $EcomAdmin->password = Hash::make($request->password);
                    $EcomAdmin->save();

                    return redirect()->back()->with('success', 'Password Changed Successfully');
                } else {
                    return redirect()->back()->with('error', 'Old Password Not Matched');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid Token');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
