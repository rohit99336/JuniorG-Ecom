<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

// Models
use App\Models\ShippingMethod;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Shipping Methods';
            $subTitle = 'List of shipping methods';
            $shipping_methods = ShippingMethod::all();
            $counter = 1;

            if (request()->ajax()) {
                $shipping_methods = ShippingMethod::select('*');
                return Datatables::of($shipping_methods)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($shipping_methods) {
                        return  '<a href="' . route('ecomadmin.setting.shipping-methods.edit', $shipping_methods->id) . '" class="btn btn-info"><i class="bx bx-edit-alt"></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $shipping_methods->id . '" data-id="' . $shipping_methods->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('ecom.admin.shippingMethods.index', compact('shipping_methods', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $title = 'Shipping Methods';
            $subTitle = 'Create Shipping Method';
            return view('ecom.admin.shippingMethods.create', compact('title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'slug' => 'nullable',
                'description' => 'nullable',
                'delivery_time' => 'nullable',
                'delivery_charge' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $offer = new ShippingMethod();
            $offer->name = $request->name;
            $offer->slug = Uuid::uuid4()->toString();
            $offer->description = $request->description;
            $offer->delivery_time = $request->delivery_time;
            $offer->delivery_charge = $request->delivery_charge;
            $offer->save();

            if ($offer) {
                return redirect()->route('ecomadmin.setting.shipping-methods.index')->with('success', 'Shipping method created successfully');
            }
            return redirect()->back()->with('error', 'Offer creation failed');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $title = 'Shipping Methods';
            $subTitle = 'Edit Shipping Method';
            $shippingmethod = ShippingMethod::find($id);
            return view('ecom.admin.shippingMethods.edit', compact('title', 'subTitle', 'shippingmethod'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'slug' => 'nullable',
                'description' => 'nullable',
                'delivery_time' => 'nullable',
                'delivery_charge' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $offer = ShippingMethod::find($id);
            $offer->name = $request->name;
            $offer->description = $request->description;
            $offer->delivery_time = $request->delivery_time;
            $offer->delivery_charge = $request->delivery_charge;
            $offer->save();

            if ($offer) {
                return redirect()->route('ecomadmin.setting.shipping-methods.index')->with('success', 'shipping method updated successfully');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $offer = ShippingMethod::find($id);
            if ($offer) {
                $offer->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Shipping method deleted successfully'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Shipping method deletion failed'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }

    //==============================================================================================//
    //======================================== API CALLS ===========================================//
    //==============================================================================================//

    /**
     * Get all the products
     */
    public function getProducts()
    {
        try {
            $methods = ShippingMethod::get();
            return response()->json([
                'success' => true,
                'methods' => $methods
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }
}
