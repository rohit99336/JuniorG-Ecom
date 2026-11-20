<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Customer;
use App\Models\EcomMaster;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\CardDetail;
use App\Models\Cart;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Orders';
            $subTitle = 'List of orders';
            $orders = Order::with('orderItems')->get();
            $counter = 1;

            if (request()->ajax()) {
                $orders = Order::with('orderItems', 'customer', 'shippingAddress', 'billingAddress', 'deletedBy')->where('status', 'processing');
                return DataTables::of($orders)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($order) {
                        return  '<a href="' . route('ecomadmin.orders.show', $order->id) . '" class="text-primary" title="View order details"><i class="bx bx-show"></i></a>'  . '&nbsp;&nbsp;<a class="text-danger delete" id="' . $order->id . '" data-id="' . $order->id . '" title="Delete order"><i class="bx bx-trash-alt "></i></a>';

                        // return  '<a href="' . route('ecomadmin.orders.show', $order->id) . '" class="text-primary" title="View order details"><i class="bx bx-show"></i></a>' . '&nbsp;&nbsp;<a href="' . route('ecomadmin.orders.edit', $order->id) . '" class="text-info" title="Edit order"><i class="bx bx-edit-alt"></i></a>' . '&nbsp;&nbsp;<a class="text-danger delete" id="' . $order->id . '" data-id="' . $order->id . '" title="Delete order"><i class="bx bx-trash-alt "></i></a>';
                    })
                    ->addColumn('customer', function ($order) {
                        return ucfirst($order->customer->name) . ' ' . ucfirst($order->customer->last_name);
                    })
                    ->addColumn('total_order_items', function ($order) {
                        return $order->orderItems->count();
                    })
                    ->addColumn('order_date', function ($order) {
                        return date('d-m-Y', strtotime($order->created_at));
                    })
                    ->addColumn('order_date', function ($order) {
                        return date('d-m-Y', strtotime($order->created_at));
                    })
                    ->addColumn('order_status', function ($order) {
                        $color = '';
                        $selected = '';

                        // Setting color and selected for each status
                        switch ($order->status) {
                            case 'Processing':
                                $color = 'btn-warning';
                                break;
                            case 'Pending':
                                $color = 'btn-info';
                                break;
                            case 'Completed':
                                $color = 'btn-success';
                                break;
                            case 'Declined':
                            case 'Refunded':
                            case 'Cancelled':
                            case 'Failed':
                                $color = 'btn-danger';
                                break;
                            default:
                                $color = 'btn-secondary';
                                break;
                        }

                        return '<select onchange="changeStatus(this)" class="form-select form-select-sm mb-3 ' . $color . '" aria-label=".form-select-sm" data-id="' . $order->id . '" name="staus_drop">
                                    <option value="processing" ' . ($order->status == 'Processing' ? 'selected' : '') . '>Processing</option>
                                    <option value="pending" ' . ($order->status == 'Pending' ? 'selected' : '') . '>Pending</option>
                                    <option value="completed" ' . ($order->status == 'Completed' ? 'selected' : '') . '>Completed</option>
                                    <option value="declined" ' . ($order->status == 'Declined' ? 'selected' : '') . '>Declined</option>
                                    <option value="refunded" ' . ($order->status == 'Refunded' ? 'selected' : '') . '>Refunded</option>
                                    <option value="cancelled" ' . ($order->status == 'Cancelled' ? 'selected' : '') . '>Cancelled</option>
                                    <option value="failed" ' . ($order->status == 'Failed' ? 'selected' : '') . '>Failed</option>
                                </select>';
                    })


                    ->rawColumns(['action', 'total_order_items', 'customer', 'order_date', 'order_status'])
                    ->make(true);
            }
            return view('ecom.admin.orders.index', compact('orders', 'title', 'subTitle'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = Customer::find(auth('customer')->user()->id);
        $cart_data = Cart::where('customer_id', $customer->id)->get();
        $sub_total = 0;
        $grand_total = 0;
        $order_number = 'SRV-OP' . Str::random(6);
        $payment_method = paymentMethods($request->paymentMethod);

        $shipping_address = Address::where('customer_id', $customer->id)
            ->where('type', 'shipping')
            ->first();

        $billing_address = Address::where('customer_id', $customer->id)
            ->where('type', 'billing')
            ->first();

        $isExist = Order::where('customer_id', $customer->id)->where('status', 'pending')->first();

        // delete existing order & order items
        if ($isExist) {
            // OrderItem::where('order_id', $isExist->id)->delete();
            // $isExist->delete();

            // delete and force delete
            $isExist->delete();
            $isExist->forceDelete();
        }

        $m_shipping_charge = EcomMaster::first()->shipping_charge;
        $free_shipping_amount = EcomMaster::first()->free_shipping_amount;

        try {
            $validator = Validator::make($request->all(), [
                'billing_first_name' => 'required',
                'billing_last_name' => 'required',
                'billing_email' => 'required|email',
                'billing_address' => 'required',
                'billing_city' => 'required',
                'billing_state_id' => 'required',
                'billing_zip' => 'required',
                'billing_phone' => 'required|numeric|digits:10',
                'shipping_first_name' => 'nullable',
                'shipping_last_name' => 'nullable',
                'shipping_email' => 'nullable|email',
                'shipping_address' => 'nullable',
                'shipping_city' => 'nullable',
                'shipping_state_id' => 'nullable',
                'shipping_zip' => 'nullable',
                'shipping_phone' => 'nullable|numeric|digits:10',
                'payment_method' => 'nullable',
                'card_number' => 'nullable',
                'card_holder_name' => 'nullable',
                'card_expiry_month' => 'nullable',
                'card_expiry_year' => 'nullable',
                'card_cvv' => 'nullable',

            ]);

            if ($validator->fails()) {
                //return redirect()->back()->withErrors($validator)->withInput();

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->all(),
                ]);
            }

            $billing = new Address();
            $billing->customer_id = $customer->id;
            $billing->first_name = $request->billing_first_name;
            $billing->last_name = $request->billing_last_name;
            $billing->email = $request->billing_email;
            $billing->phone = $request->billing_phone;
            $billing->address = $request->billing_address;
            $billing->city = $request->billing_city;
            $billing->state_id = $request->billing_state_id;
            $billing->zip = $request->billing_zip;
            $billing->country_id  = 101;
            $billing->type = 'billing';
            $billing->save();

            // if (!$shipping_address) {
            if ($request->same_address != 'on') {
                $shipping = new Address();
                $shipping->customer_id = $customer->id;
                $shipping->first_name = $request->shipping_first_name;
                $shipping->last_name = $request->shipping_last_name;
                $shipping->email = $request->shipping_email;
                $shipping->phone = $request->shipping_phone;
                $shipping->address = $request->shipping_address;
                $shipping->city = $request->shipping_city;
                $shipping->state_id = $request->shipping_state_id;
                $shipping->country_id  = 101;
                $shipping->zip = $request->shipping_zip;
                $shipping->type = 'shipping';
                $shipping->save();
            } else {
                $shipping = new Address();
                $shipping->customer_id = $billing->customer_id;
                $shipping->first_name = $billing->first_name;
                $shipping->last_name = $billing->last_name;
                $shipping->email = $billing->email;
                $shipping->phone = $billing->phone;
                $shipping->address = $billing->address;
                $shipping->city = $billing->city;
                $shipping->state_id = $billing->state_id;
                $shipping->country_id  = 101;
                $shipping->zip = $billing->zip;
                $shipping->type = 'shipping';
                $shipping->save();
            }

            // create new order and order items
            $order = new Order();
            $order->order_number = $order_number;
            $order->customer_id = $customer->id;
            $order->billing_address_id = $billing->id;
            $order->shipping_address_id = $shipping->id;
            $order->payment_method_id = $payment_method ?? 1;
            $order->shipping_method_id = 1;
            $order->status_id = 1;
            $order->currency_id = 1;
            $order->subtotal = $sub_total;
            $order->tax = 0;
            $order->shipping = 0;
            $order->discount = 0;
            $order->total = $grand_total;
            $order->payment_gateway = '';
            $order->payment_id = '';
            $order->payment_status = 'Unpaid';
            $order->payment_details = '';
            $order->shipping_number = '';
            $order->shipping_details = 'pending';
            $order->shipping_status = 'pending';
            $order->shipping_label = 'pending';
            $order->tracking_number = '';
            $order->tracking_link = 'https://www.google.com';
            $order->tracking_details = 'pending';
            $order->tracking_status = 'pending';
            $order->tracking_label = 'pending';
            $order->tracking_shipped = 1;
            $order->tracking_delivered = 1;
            $order->tracking_delivery_date = date('Y-m-d');
            $order->tracking_delivery_time = date('H:i:s');
            $order->status = 'pending';
            $order->notes = '';
            $order->customer_notes = '';
            $order->save();

            // update order_id in address
            $billing->order_id = $order->id;
            $billing->save();

            $shipping->order_id = $order->id;
            $shipping->save();


            // order items
            foreach ($cart_data as $cart) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cart->product_id;
                $orderItem->product_variant_id = $cart->product_variant_id;
                $orderItem->quantity = $cart->quantity;
                $orderItem->price = $cart->price;
                $orderItem->total = $cart->price * $cart->quantity;
                $orderItem->customer_id = $customer->id;
                $orderItem->save();

                // update sub total and grand total
                $sub_total += $cart->price * $cart->quantity;
                $grand_total = $sub_total;
            }

            // if total is greater than or equal to free shipping amount, then add m shipping charge
            if ($sub_total >= $free_shipping_amount) {
                $shipping = 0;
            } else {
                $grand_total += $m_shipping_charge;
                $order->shipping = $m_shipping_charge;
            }

            // update order sub total and grand total
            $order->subtotal = $sub_total;
            $order->total = $grand_total;
            $order->save();

            $payment_route = "payment/" . $order->id;

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'payment_route' => $payment_route,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong, please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $order = Order::with('orderItems', 'customer', 'shippingAddress', 'billingAddress', 'deletedBy', 'OrderPayments')->find($id);
            // Fetch order status options separately
            $orderStatusOptions = Order::getAllStatusOptions();
            // Log::info($orderStatusOptions);
            // Log::info('order: ' . $order);
            $title = 'Order Details';
            $subTitle = 'Order details';
            return view('ecom.admin.orders.show', compact('order', 'title', 'subTitle', 'orderStatusOptions'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        try {
            $ecomAdmin = auth('ecomadmin')->user();
            $order = Order::find($id);
            $order->delete();

            // update deleted by
            $order->deleted_by = $ecomAdmin->id;
            $order->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Order deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.',
            ]);
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request)
    {
        // Log::info($request->all());
        try {
            $order = Order::find($request->order_id);
            $order->status = $request->status;
            $order->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Order status updated successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.',
            ]);
        }
    }

    /**
     * Generate invoice for the order
     */
    public function invoice(string $id)
    {
        try {
            $order = Order::with('orderItems', 'customer', 'shippingAddress', 'billingAddress', 'deletedBy')->find($id);

            $title = 'Order Invoice';
            $subTitle = 'Order invoice';
            return view('ecom.admin.orders.invoice', compact('order', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
