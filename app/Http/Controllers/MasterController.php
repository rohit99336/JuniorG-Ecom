<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Log;

class MasterController extends Controller
{

    /**
     * Get Country.
     */
    public function getCountries(Request $request)
    {
        try {
            if ($request->ajax()) {
                $country = Country::get();
                return response()->json(['countries' => $country], 200);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get State.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStates(Request $request)
    {
        try {
            if ($request->ajax()) {
                $state = State::where('country_id', $request->country_id)->get();
                return response()->json(['states' => $state], 200);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get City.
     */
    public function getCities(Request $request)
    {

        try {
            if ($request->ajax()) {
                $city = City::where('state_id', $request->state_id)->get();
                return response()->json(['cities' => $city], 200);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
