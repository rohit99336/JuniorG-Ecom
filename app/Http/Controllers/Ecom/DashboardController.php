<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        try{
            $user = auth()->guard('ecomadmin')->user();
            return view('ecom.admin.dashboard.index');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Logout and redirect login page
     */
    public function goToSalon(Request $request)
    {
        try {
            Auth::guard('ecomadmin')->logout();
            return redirect()->route('login');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('ecomLogin')->with('error', 'Something went wrong!');
        }
    }

}
