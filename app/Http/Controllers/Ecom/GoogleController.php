<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            // Log::info($user);

            // // Log basic user information
            // Log::info('Google User Information:', [
            //     'User ID' => $user->getId(),
            //     'Name' => $user->getName(),
            //     'Email' => $user->getEmail(),
            //     'Avatar' => $user->getAvatar(),
            //     // Add more information as needed
            // ]);

            $finduser = Customer::where('google_id', $user->id)->first();

            if ($finduser) {
                $user = Auth::guard('customer')->login($finduser);

                // cart()->restore($finduser->id);
                cart();

                return redirect()->route('shop.products');
            } else {
                $newUser = Customer::updateOrCreate(['email' => $user->email], [
                    'customer_id' => 'JNR' . rand(100000, 999999),
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'avatar' => $user->avatar,
                    'password' => Hash::make('password'),
                ]);

                // login customer
                $user = Auth::guard('customer')->login($newUser);

                // call cart helper function
                cart();

                // redirect to dashboard
                return redirect()->route('shop.products');
            }
        } catch (Exception $e) {
            // dd($e->getMessage());
            Log::error($e->getMessage());
            return redirect()->route('shop.products');
        }
    }
}
