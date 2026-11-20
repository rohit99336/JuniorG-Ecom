<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Cart;
use App\Models\EcomMaster;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CartController extends Controller
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
            $customer = auth()->guard('customer')->user();

            // if customer is not logged in
            if (!$customer) {
                return redirect()->route('shop.login')
                    ->with('error', 'Please login to add product to cart!');
            } else {
                $product = Product::where('slug', $request->slug)->first();
                $variant = ProductVariant::where('id', $request->variant_id)->first();
                $cart = Cart::where('customer_id', $customer->id)
                    ->where('product_id', $product->id)
                    ->where('variant_id', $variant->id)
                    ->first();

                if ($cart) {
                    $cart->quantity = $cart->quantity + $request->quantity;
                    $cart->save();
                } else {
                    $cart = new Cart();
                    $cart->customer_id = $customer->id;
                    $cart->product_id = $product->id;
                    $cart->variant_id = $variant->id;
                    $cart->quantity = $request->quantity;
                    $cart->save();
                }
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
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

    //==========================================================================================//
    //======================================== Custom Methods ==================================//

    /**
     * Add to cart
     */
    public function addToCart(Request $request)
    {
        // Log::info($request->all());
        try {
            $customer = auth()->guard('customer')->user();
            $variant = ProductVariant::where('uuid', $request->product_variant_id)->first();
            $product = Product::find($variant->product_id);
            $shipping_charge = EcomMaster::first()->shipping_charge;
            $free_shipping_amount = EcomMaster::first()->free_shipping_amount;

            if (!$customer) {
                // Guest user
                $cart = session()->get('cart', []);

                // Check if the item already exists in the cart, then do not overwrite quantity
                if (isset($cart[$request->product_variant_id])) {
                    $cartItem = $cart[$request->product_variant_id];
                    $cartItem['quantity'] += $request->quantity ?? 1;
                    $cartItem['total'] = $variant->price * $cartItem['quantity'];
                    $cartItem['grand_total'] = $variant->price * $cartItem['quantity'];

                    // add shipping charge if total is less than free shipping amount
                    if ($cartItem['total'] < $free_shipping_amount) {
                        $cartItem['grand_total'] += $shipping_charge;
                        $cartItem['shipping'] = $shipping_charge;
                    } else {
                        $cartItem['grand_total'] = $cartItem['total'];
                        $shipping_charge = 0;
                        $cartItem['shipping'] = $shipping_charge;
                    }
                } else {
                    $cartItem = [
                        'product_id' => $product->id,
                        'product_variant_id' => $variant->id,
                        'product_category' => $product->category->name,
                        // 'name' => $variant->name,
                        'name' => $product->name,
                        'ip_address' => $request->ip(),
                        'quantity' => $request->quantity ?? 1,
                        'price' => $variant->price,
                        'image' => $variant->thumbnail_image,
                        'total' => $variant->price * ($request->quantity ?? 1),
                        'grand_total' => $variant->price * ($request->quantity ?? 1),
                    ];
                }

                // Update cart with the modified or new cart item
                $cart[$request->product_variant_id] = $cartItem;
                session()->put('cart', $cart);

                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Product added to cart successfully!',
                        'cart' => $cart
                    ]);
                }

                // Redirect back to the cart page
                // return redirect()->route('shop.cart')->with('success', 'Product added to cart successfully!');

                if(request()->ajax()){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Product added to cart successfully!',
                        'cart' => $cart
                    ]);
                }

                return redirect()->back()->with('success', 'Product added to cart successfully!');
            } else {
                // Logged-in user
                $existingCartItem = Cart::where('customer_id', $customer->id)
                    ->where('product_variant_id', $variant->id)
                    ->first();

                if ($existingCartItem) {
                    // If cart item already exists, do not add extra quantity
                    $quantity = $existingCartItem->quantity;
                } else {
                    $quantity = $request->quantity ?? 1;
                }

                $cart = Cart::updateOrCreate(
                    ['customer_id' => $customer->id, 'product_variant_id' => $variant->id],
                    // ['ip_address' => $request->ip(), 'product_variant_id' => $variant->id],
                    [
                        'product_id' => $product->id,
                        'ip_address' => $request->ip(),
                        // 'name' => $variant->name,
                        'name' => $product->name,
                        'image' => $variant->thumbnail_image,
                        'quantity' => $quantity,
                        'price' => $variant->price,
                        'total' => $variant->price * $quantity,
                        'grand_total' => $variant->price * $quantity,
                        'shipping' => 0,
                        'estimate_shipping_date' => date('Y-m-d', strtotime('+' . $product->estimate_shipping_time . ' days'))
                    ]
                );

                // Get updated cart items and store in session
                $updatedCart = Cart::where('customer_id', $customer->id)->get();
                session()->put('cart', $updatedCart);

                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove from cart
     */
    public function removeFromCart($product_variant_id)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $variant = ProductVariant::where('id', $product_variant_id)->first();
            $product = Product::where('id', $variant->product_id)->first();

            // if customer is not logged in
            if (!$customer) {
                // return redirect()->route('shop.login')
                //     ->with('error', 'Please login to add product to cart!');

                // get cart data from session
                $sessioncartData = session()->get('cart');

                foreach ($sessioncartData as $key => $cart) {
                    if ($cart['product_variant_id'] == $product_variant_id) {
                        unset($sessioncartData[$key]);
                    }
                }

                // save cart items to session
                session()->put('cart', $sessioncartData);

                return redirect()->back()->with('success', 'Product removed from cart successfully!');
            } else {

                $cart = Cart::where('customer_id', $customer->id)
                    ->where('product_id', $product->id)
                    ->where('product_variant_id', $variant->id)
                    ->first();

                if ($cart) {
                    $cart->delete();
                }

                $cart = Cart::where('customer_id', Auth::guard('customer')->user()->id)->get();
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Product removed from cart successfully!');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Go to cart
     */
    public function goToCart()
    {
        try {
            $title = 'Cart';
            // return view('ecom.cart');
            // return view('ecom.web.cart');
            return view('ecom.web.cart', compact('title'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }


    /**
     * Update cart
     */
    public function updateCart(Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();

            // if customer is not logged in
            if (!$customer) {
                // get cart data from session
                $sessioncartData = session()->get('cart');

                foreach ($sessioncartData as $key => $cart) {
                    if ($key == $request->id) {
                        $sessioncartData[$key]['quantity'] = $request->quantity;
                        $sessioncartData[$key]['total'] = $cart['price'] * $request->quantity;
                        $sessioncartData[$key]['grand_total'] = $cart['price'] * $request->quantity;
                    }
                }

                // save cart items to session
                session()->put('cart', $sessioncartData);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Cart updated successfully!',
                    'cart' => $sessioncartData
                ]);
            } else {
                $cart = Cart::where('customer_id', $customer->id)
                    ->where('product_variant_id', $request->product_variant_id)
                    ->first();
                if ($cart) {
                    $cart->quantity = $request->quantity;
                    $cart->total = $cart->price * $request->quantity;
                    $cart->grand_total = $cart->price * $request->quantity;
                    $cart->save();
                }

                $cart = Cart::where('customer_id', $customer->id)->get();
                session()->put('cart', $cart);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Cart updated successfully!',
                    'cart' => $cart
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }


    /**
     * Checkout
     */
    public function checkout()
    {
        try {
            // Check if customer is authenticated
            $customer = auth()->guard('customer')->user();
            if (!$customer) {
                return redirect()->route('shop.login')
                    ->with('error', 'Please log in to proceed to checkout!');
            }

            // Retrieve countries and states
            $countries = Country::all();
            $states = State::where('country_id', 101)->get();
            $cities = City::where('country_id', 101)->get();

            // Retrieve shipping and billing addresses
            $shipping_address = Address::where('customer_id', $customer->id)
                ->where('type', 'shipping')
                ->first();

            $billing_address = Address::where('customer_id', $customer->id)
                ->where('type', 'billing')
                ->first();

            $m_shipping_charge = EcomMaster::first()->shipping_charge;
            $free_shipping_amount = EcomMaster::first()->free_shipping_amount;

            // Retrieve cart data with eager loading
            $cartData = Cart::with('productVariant')
                ->where('customer_id', $customer->id)
                ->get();

            $subtotals = [];
            $total = 0;
            $shipping = 0;
            $grand_total = 0;
            $title = 'Checkout';
            $subTitle = 'Cart';

            foreach ($cartData as $key => $cart) {
                $product_variant = $cart->productVariant;
                $subtotals[$key] = $product_variant->price * $cart->quantity;
                $shipping_charge = $product_variant->shipping_charge;
                $shipping += $shipping_charge;
                $total += $subtotals[$key];
                $grand_total += $subtotals[$key];
            }

            // Convert integer values to float
            $total = (float) $total;
            $shipping = (float) $shipping;

            // if total is greater than or equal to free shipping amount, then add m shipping charge
            if ($total >= $free_shipping_amount) {
                $shipping = 0;
            } else {
                $grand_total += $m_shipping_charge;
                $shipping = $m_shipping_charge;
            }

            $grand_total = (float) $grand_total;

            return view('ecom.web.checkout', compact(
                'cartData',
                'subtotals',
                'total',
                'shipping',
                'grand_total',
                'countries',
                'states',
                'cities',
                'shipping_address',
                'billing_address',
                'm_shipping_charge',
                'title',
                'subTitle'
            ));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
