<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\ProductOffer;
use App\Models\ProductOfferItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Offer';
            $subTitle = 'List of offers';
            $offers = ProductOffer::all();
            $counter = 1;

            if (request()->ajax()) {
                $offers = ProductOffer::with('offerItems', 'creater');
                return Datatables::of($offers)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($offer) {
                        return  '<a href="' . route('ecomadmin.offers.edit', $offer->id) . '" class="btn btn-info"><i class="bx bx-edit-alt"></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $offer->id . '" data-id="' . $offer->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->addColumn('creater', function ($offer) {
                        return $offer->creater->name;
                    })
                    ->editColumn('is_active', function ($offer) {
                        return $offer->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    })
                    ->editColumn('image', function ($offer) {
                        return '<img src="' . $offer->image . '" alt="' . $offer->name . '" width="70" height="70">';
                    })
                    // ->addColumn('offerItems', function ($offer) {
                    //     $offerItems = '';
                    //     foreach ($offer->offerItems as $offerItem) {
                    //         $offerItems .= '<span class="badge bg-success">' . $offerItem->productVariant->product->name . '</span>&nbsp;';
                    //     }
                    //     return $offerItems;
                    // })
                    ->addColumn('total_offer_items', function ($offer) {
                        return $offer->offerItems->count();
                    })

                    ->rawColumns(['action', 'image', 'is_active', 'creater', 'offerItems', 'total_offer_items'])
                    ->make(true);
            }
            return view('ecom.admin.offers.index', compact('offers', 'title', 'subTitle'));
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
            $title = 'Offer';
            $subTitle = 'Create offer';
            $products = ProductVariant::with('product', 'color', 'unit')->get();
            return view('ecom.admin.offers.create', compact('title', 'subTitle', 'products'));
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
                'description' => 'nullable',
                'offer_code' => 'required',
                'offer_type' => 'required',
                // 'is_active' => 'required',
                'offer_value' => 'required',
                'offer_start_time' => 'required',
                'offer_end_time' => 'required',
                'image' => 'nullable',
                'terms' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $offer = new ProductOffer();
            $offer->name = $request->name;
            $offer->horizontal_subheading = $request->horizontal_subheading;
            $offer->vertical_subheading = $request->vertical_subheading;
            $offer->heading = $request->heading;
            $offer->offer_text = $request->offer_text;
            $offer->button_text = $request->button_text;
            $offer->button_link = $request->button_link;
            $offer->description = $request->description;
            $offer->offer_code = $request->offer_code;
            $offer->offer_type = $request->offer_type;
            $offer->offer_value = $request->offer_value;
            $offer->offer_start_time = $request->offer_start_time;
            $offer->offer_end_time = $request->offer_end_time;
            $offer->image = $request->image;
            $offer->terms = $request->terms;
            $offer->is_sel_all = $request->is_sel_all;
            $offer->is_active = $request->is_active ? $request->is_active  : true;
            $offer->created_by = auth()->guard('ecomadmin')->user()->id;
            $offer->updated_by = auth()->guard('ecomadmin')->user()->id;
            $offer->save();

            if ($offer) {
                $variants = $request->variant_ids;
                foreach ($variants as $offerItem) {
                    $variant = ProductVariant::find($offerItem);
                    $product_price = $variant->price;
                    if ($offer->offer_type == 'percentage') {
                        $discount_price = ($offer->offer_value / 100) * $product_price;
                        $discounted_price = $product_price - $discount_price;
                    } else if ($offer->offer_type == 'fixed') {
                        $discount_price = $offer->offer_value;
                        $discounted_price = $product_price - $discount_price;
                    } else {
                        $discount_price = 0;
                        $discounted_price = $product_price;
                    }

                    $offerItem = new ProductOfferItem();
                    $offerItem->product_offer_id = $offer->id;
                    $offerItem->category_id = $variant->product->category_id;
                    $offerItem->product_id = $variant->product_id;
                    $offerItem->product_variant_id = $variant->id;
                    $offerItem->product_price = $product_price;
                    $offerItem->discount_price = $discount_price;
                    $offerItem->discount_type = $offer->offer_type;
                    $offerItem->discounted_price = $discounted_price;
                    $offerItem->discount_value =  $request->offer_value;
                    // $offerItem->total = $offerItem->discounted_price * $offerItem->quantity;
                    // $offerItem->total_discount = $offerItem->discount_price * $offerItem->quantity;
                    // $offerItem->grand_total = $offerItem->total - $offerItem->total_discount;
                    // $offerItem->created_by = auth()->guard('ecomadmin')->user()->id;
                    $offerItem->save();
                }
            }

            if ($offer) {
                return redirect()->route('ecomadmin.offers.index')->with('success', 'Offer created successfully');
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
            $title = 'Offer';
            $subTitle = 'Edit offer';
            $offer = ProductOffer::with('offerItems')->find($id);
            $products = ProductVariant::with('product', 'color', 'unit')->get();
            return view('ecom.admin.offers.edit', compact('title', 'subTitle', 'offer', 'products'));
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
                'description' => 'nullable',
                'offer_code' => 'required',
                'offer_type' => 'required',
                // 'is_active' => 'required',
                'offer_value' => 'required',
                'offer_start_time' => 'required',
                'offer_end_time' => 'required',
                'image' => 'nullable',
                'terms' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $offer = ProductOffer::find($id);
            $offer->name = $request->name;
            $offer->horizontal_subheading = $request->horizontal_subheading;
            $offer->vertical_subheading = $request->vertical_subheading;
            $offer->heading = $request->heading;
            $offer->offer_text = $request->offer_text;
            $offer->button_text = $request->button_text;
            $offer->button_link = $request->button_link;
            $offer->description = $request->description;
            $offer->offer_code = $request->offer_code;
            $offer->offer_type = $request->offer_type;
            $offer->offer_value = $request->offer_value;
            $offer->offer_start_time = $request->offer_start_time;
            $offer->offer_end_time = $request->offer_end_time;
            $offer->image = $request->image;
            $offer->terms = $request->terms;
            $offer->is_sel_all = $request->is_sel_all;
            $offer->is_active = $request->is_active ? $request->is_active  : true;
            $offer->updated_by = auth()->guard('ecomadmin')->user()->id;
            $offer->save();

            if ($offer) {
                // Delete all the offer items
                $offerItems = ProductOfferItem::where('product_offer_id', $offer->id)->get();
                foreach ($offerItems as $offerItem) {
                    $offerItem->delete();
                }

                $variants = $request->variant_ids;
                foreach ($variants as $offerItem) {
                    $variant = ProductVariant::find($offerItem);
                    $product_price = $variant->price;
                    if ($offer->offer_type == 'percentage') {
                        $discount_price = ($offer->offer_value / 100) * $product_price;
                        $discounted_price = $product_price - $discount_price;
                    } else if ($offer->offer_type == 'fixed') {
                        $discount_price = $offer->offer_value;
                        $discounted_price = $product_price - $discount_price;
                    } else {
                        $discount_price = 0;
                        $discounted_price = $product_price;
                    }

                    $offerItem = new ProductOfferItem();
                    $offerItem->product_offer_id = $offer->id;
                    $offerItem->category_id = $variant->product->category_id;
                    $offerItem->product_id = $variant->product_id;
                    $offerItem->product_variant_id = $variant->id;
                    $offerItem->product_price = $product_price;
                    $offerItem->discount_price = $discount_price;
                    $offerItem->discount_type = $offer->offer_type;
                    $offerItem->discounted_price = $discounted_price;
                    $offerItem->discount_value =  $request->offer_value;
                    $offerItem->save();
                }
            }

            if ($offer) {
                return redirect()->route('ecomadmin.offers.index')->with('success', 'Offer updated successfully');
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
            $offer = ProductOffer::find($id);
            if ($offer) {
                $offer->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Offer deleted successfully'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Offer deletion failed'
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
            $products = ProductVariant::with('product', 'color', 'unit')->get();
            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }
}
