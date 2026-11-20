<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\ProductRating;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'rating' => 'numeric|required',
                'product_id' => 'required',
                'product_variant_id' => 'required',
                'comment' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $customer_id = auth()->guard('customer')->user()->id;
            $product_id = $request->product_id;
            $product_variant_id = $request->product_variant_id;

            // Check if the customer has already reviewed this product
            $existingReview = ProductRating::where('customer_id', $customer_id)
                ->where('product_id', $product_id)
                ->where('product_variant_id', $product_variant_id)
                ->first();

            if ($existingReview) {
                // Update the existing review
                $existingReview->update([
                    'rating' => $request->rating,
                    'message' => $request->comment,
                ]);

                $message = 'Review updated successfully';
            } else {
                // Create a new review
                ProductRating::create([
                    'customer_id' => $customer_id,
                    'product_id' => $product_id,
                    'product_variant_id' => $product_variant_id,
                    'rating' => $request->rating,
                    'message' => $request->comment,
                ]);

                $message = 'Review submitted successfully';
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            Log::error("Error on add/update review: " . $e->getMessage());
            return back()->with('error', 'Failed to submit review. Please try again.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
