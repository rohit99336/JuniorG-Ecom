<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Log;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer')->except('logout');
    }

    public function shippingMethods()
    {
        $shippingMethods = ShippingMethod::all();
        return $shippingMethods;
    }

}
