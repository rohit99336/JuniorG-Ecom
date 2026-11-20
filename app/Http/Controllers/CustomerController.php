<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Cart;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Rules\ReCaptcha;

class CustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating customers  for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect customers  after login.
     *
     * @var string
     */
    protected $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('guest:customer', ['except' => ['ecomLogout']]);
    }

    /**
     * Register form Page
     */
    public function registerForm()
    {
        // return view('ecom.auth.register');
        return view('ecom.web.customer.auth.register');
    }

    /**
     * Register a new customer instance after a valid registration.
     *
     * @request POST
     */
    protected function register(Request $request)
    {
        // Log::info($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|min:3',
                'email' => 'required|string|email|max:255|unique:customers',
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6|same:password',
                'phone' => 'required|numeric|digits:10|unique:customers',
                'address' => 'string|max:255|min:3|nullable',
                'state_id' => 'numeric|nullable',
                'city_id' => 'numeric|nullable',
                'pincode_id' => 'numeric|nullable',
                'gst_number' => 'nullable|string|max:255|min:3',
                'pan_number' => 'nullable|string|max:255|min:3',
                'aadhar_number' => 'nullable|string|max:255|min:3',
                // 'g-recaptcha-response' => ['required', new ReCaptcha],
            ]);

            // return all errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // create customer
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'customer_id' => 'JNR' . rand(100000, 999999),
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'pincode_id' => $request->pincode_id,
                'gst_number' => $request->gst_number,
                'pan_number' => $request->pan_number,
                'aadhar_number' => $request->aadhar_number,
            ]);

            $data = [
                'name' => $customer->name,
                'email' => $customer->email,
            ];

            $subject = 'Welcome to ' . config('app.name');
            Mail::send('master.mails.ecomWelcome', ['data' => $data], function ($message) use ($data, $subject) {
                $message->to($data['email'], $data['name'])->subject($subject);
            });

            // login customer
            $user = Auth::guard('customer')->login($customer);

            // Call helper function cart()
            cart();

            // redirect to dashboard
            return redirect()->route('shop.products');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Login Page
     */
    public function showLoginForm()
    {
        $user = auth()->guard('customer')->user();
        return view('ecom.web.customer.auth.login');
    }


    /**
     * Login a new customer instance after a valid login.
     *
     * @request POST
     */
    protected function login(Request $request)
    {
        try {
            // Track login attempts per email
            $loginAttempts = session('login_attempts') ?: [];
            $email = $request->email;
            $maxAttempts = 3;
            $lockoutTime = 60; // 60 minutes in seconds

            if (isset($loginAttempts[$email]) && $loginAttempts[$email]['attempts'] >= $maxAttempts) {
                // Check if the lockout time has passed
                if (time() - $loginAttempts[$email]['last_attempt'] < $lockoutTime * 60) {
                    $remainingTime = $lockoutTime * 60 - (time() - $loginAttempts[$email]['last_attempt']);
                    $remainingMinutes = ceil($remainingTime / 60);
                    $lastAttemptTime = date('Y-m-d H:i:s', $loginAttempts[$email]['last_attempt']);
                    return redirect()->back()->with('error', 'Too many login attempts. Please try again after ' . $remainingMinutes . ' minutes. Number of attempts made: ' . $loginAttempts[$email]['attempts'] . '. Last attempt: ' . $lastAttemptTime);
                } else {
                    // Reset attempts if lockout time has passed
                    unset($loginAttempts[$email]);
                    session()->put('login_attempts', $loginAttempts);
                }
            }

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
                Cookie::queue('email', $request->email, 100);
                Cookie::queue('password', $request->password, 100);
            } else {
                Cookie::queue('email', $request->email, 60 * 24 * 30); // 30 days
                Cookie::queue('password', $request->password, 60 * 24 * 30); // 30 days
            }

            // attempt to login
            if (Auth::guard('customer')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                // add user to session
                session()->put('user', Auth::guard('customer')->user());

                // Call helper function cart()
                cart();

                // get cart items
                $cart = Cart::where('customer_id', Auth::guard('customer')->user()->id)->get();
                session()->put('cart', $cart);

                // Reset login attempts upon successful login
                if (isset($loginAttempts[$email])) {
                    unset($loginAttempts[$email]);
                    session()->put('login_attempts', $loginAttempts);
                }

                return redirect()->route('shop.products');
            } else {
                // Record login attempt
                if (isset($loginAttempts[$email])) {
                    $loginAttempts[$email]['attempts']++;
                    $loginAttempts[$email]['last_attempt'] = time();
                    $remainingAttempts = $maxAttempts - $loginAttempts[$email]['attempts'];
                } else {
                    $loginAttempts[$email] = [
                        'attempts' => 1,
                        'last_attempt' => time(),
                    ];
                    $remainingAttempts = $maxAttempts - 1; // First attempt counts as one
                }

                // add login attempts to session
                session()->put('login_attempts', $loginAttempts);

                Log::error($request->email . " has failed to login.");
                $error_message = 'Invalid Credentials';
                if ($remainingAttempts > 0) {
                    $error_message .= '. ' . $remainingAttempts . ' attempt(s) remaining.';
                }

                return redirect()->back()->with('error', $error_message)->withInput($request->only('email', 'password'));
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Logout a new customer instance after a valid login.
     *
     * @request POST
     */
    protected function ecomLogout(Request $request)
    {
        try {
            // Auth::guard('customer')->logout();

            // destroy all session
            Auth::guard('customer')->logout();
            $request->session()->flush();
            $request->session()->regenerate();

            //return redirect()->route('shop.login');
            return redirect()->route('shop.index');
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
            $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
            if ($customer) {
                $customer->tokens()->delete();
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
            $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
            if ($customer) {
                $customer->currentAccessToken()->delete();
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
            return redirect()->route('shop.products');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('shop.login')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Forgot Password Page
     */
    public function showForgotPasswordForm()
    {
        // return view('ecom.auth.forgot-password');
        return view('ecom.web.customer.auth.forgot-password');
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

            $customer = Customer::where('email', $request->email)->first();

            if ($customer) {
                $token = Str::random(60);
                $customer->password_reset_token = $token;
                $customer->password_reset_at = Carbon::now();
                $customer->save();

                $data = [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'token' => $token,
                ];

                Mail::send('ecom.web.customer.auth.reset-mail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'], $data['name'])->subject('Password Reset Request');
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
        $customer = Customer::where('password_reset_token', $token)->first();

        if ($customer) {
            // return view('ecom.auth.reset-password', compact('customer'));
            return view('ecom.web.customer.auth.reset-password', compact('customer'));
        } else {
            return redirect()->route('shop.login')->with('error', 'Invalid Token');
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
                'password_confirmation' => 'required|min:6|same:password',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $customer = Customer::where('password_reset_token', $request->token)
                ->where('email', $request->email)
                ->first();

            if ($customer) {
                if ($customer->password_reset_at && Carbon::parse($customer->password_reset_at)->diffInMinutes(Carbon::now()) > 60) {
                    $customer->password_reset_token = null;
                    $customer->password_reset_at = null;
                    $customer->save();
                    return redirect()->route('shop.login')->with('error', 'Token Expired');
                }

                // Reset password logic
                $customer->password = Hash::make($request->password);
                $customer->password_reset_token = null;
                $customer->password_reset_at = null;
                $customer->save();

                return redirect()->route('shop.login')->with('success', 'Password Reset Successfully');
            } else {
                // Customer not found, handle accordingly
                return redirect()->route('shop.login')->with('error', 'Invalid Token');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Expire after 60 minutes
     */
    public function expireToken($token)
    {
        $customer = Customer::where('password_reset_token', $token)->first();
        if ($customer) {
            $customer->password_reset_token = null;
            $customer->password_reset_at = null;
            $customer->save();
            return redirect()->route('shop.login')->with('error', 'Token Expired');
        } else {
            return redirect()->route('shop.login')->with('error', 'Invalid Token');
        }
    }


    /**
     * Change Password Page
     */
    public function showChangePasswordForm()
    {
        return view('customer.auth.change-password');
    }

    /**
     * Change Password
     */
    public function changePassword(Request $request)
    {
        // Log::info($request->all());
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

            $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
            if ($customer) {
                if (Hash::check($request->old_password, $customer->password)) {
                    $customer->password = Hash::make($request->password);
                    $customer->save();

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

    //======================================= Login with otp ========================//

    /**
     * Find customer by phone number
     */
    public function findUserByPhone($phone)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'message' => 'required',
        //     'g-recaptcha-response' => ['required', new ReCaptcha],
        // ]);

        // if ($validator->fails()) {
        //     // Log::info($validator->errors());
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // Log::info($phone);
        // $phone = $request->phone;
        $user = Customer::where('phone', $phone)->first();

        // Log::info($user);

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
                'phone' => $phone,
                'statusCode' => 200,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Customer not found. Please register',
            ]);
        }
    }

    /**
     * Store otp in database
     */
    public function storeOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            // Log::info($validator->errors());
            // return redirect()->back()->withErrors($validator)->withInput();

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $phone = $request->phone;
        $otp = $request->otp;

        $user = Customer::where('phone', $phone)->first();

        if ($user) {
            $user->otp = $otp;
            $user->save();
            // return redirect()->route('shop.index');

            return response()->json([
                'success' => true,
                'user' => $user,
                'phone' => $phone,
                'statusCode' => 200,
                'message' => 'OTP sent successfully',
                'otp' => $otp,
                'redirectUrl' => route('shop.index'),
                'redirectRoute' => 'shop.index',
                'redirectRouteName' => 'shop.index',
            ]);
        } else {
            // return redirect()->back()->with('error', 'Invalid Phone Number');
            return response()->json([
                'success' => false,
                'error' => 'Customer not found. Please register',
            ]);
        }
    }

    /**
     * Login with otp
     */
    public function loginWithOtp(Request $request)
    {
        try {
            // Log incoming request data for debugging
            // Log::info($request->all());

            // Extract phone number and OTP from request
            $phone = $request->phone;
            $otp = $request->otp;

            // Check if phone number starts with country code prefix '+91' (or similar)
            if (substr($phone, 0, 3) === '+91') {
                // Remove the country code prefix (e.g., '+91') from the phone number
                $phone = substr($phone, 3); // Keep the digits after the country code
            }

            // Log the modified phone number (without country code)
            // Log::info("Processed Phone: " . $phone);

            // Find user by phone number (without country code)
            $user = Customer::where('phone', $phone)->first();

            if ($user) {
                // Perform OTP verification (uncomment and implement if needed)
                // if ($user->otp == $otp) {
                //     Auth::guard('customer')->login($user);
                //     return redirect()->route('shop.index');
                // } else {
                //     return redirect()->back()->with('error', 'Invalid OTP');
                // }

                Auth::guard('customer')->login($user);

                // Call helper function cart()
                cart();
            } else {
                // create new customer
                $customer = Customer::create([
                    'name' => $phone,
                    'customer_id' => 'JNR' . rand(100000, 999999),
                    'password' => Hash::make($phone),
                    'phone' => $phone,
                ]);

                // login customer
                $user = Auth::guard('customer')->login($customer);

                // Call helper function cart()
                cart();
            }

            // Return success response with user data and redirection details
            return response()->json([
                'status' => 'success',
                'message' => 'you are logged in successfully',
                'redirectUrl' => route('shop.index'),
                'redirectRoute' => '/',
                'redirectRouteName' => '/',
                'statusCode' => 200,
                'user' => $user, // Include user data in the response
                'phone' => $phone,
                'otp' => $otp,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return  response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'statusCode' => 500,
            ]);
        }
    }
}
