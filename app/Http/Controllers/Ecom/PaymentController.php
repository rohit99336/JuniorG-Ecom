<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Payment;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $title = 'Payment';
        $subTitle = 'List of payments';
        $counter = 1;

        if (request()->ajax()) {
            $payments = Payment::with('order', 'customer');
            return DataTables::of($payments)
                ->addColumn('sr_no', function () use (&$counter) {
                    return $counter++;
                })
                // ->addColumn('action', function ($payment) {
                //     if ($payment->payment_method  == "Cashfree") {
                //         return  '<a href="' . route('ecomadmin.payments.refund', $payment->order->order_number) . '" class="text-primary" title="Refund payment ">Refund</a>';
                //     }
                // })
                ->addColumn('customer', function ($payment) {
                    return ucfirst($payment->customer->name) . ' ' . ucfirst($payment->customer->last_name);
                })
                ->addColumn('orderId', function ($payment) {
                    return '<a href="' . route('ecomadmin.orders.show', $payment->order->id) . '" title="View payment details">' . $payment->order->order_number . '</a>';
                })
                ->addColumn('payment_date', function ($order) {
                    return date('d-m-Y', strtotime($order->created_at));
                })

                ->rawColumns(['action', 'customer', 'order_date', 'orderId'])
                ->make(true);
        }
        return view('ecom.admin.payments.index', compact('title', 'subTitle'));

        // return view('ecom.admin.payments.index')->with('title', $title);
    }


    //===============================================================//

    public function paymentPage($order_id)
    {
        $customer = auth('customer')->user();
        $order = Order::with('shippingAddress', 'billingAddress')->where('id', $order_id)->first();
        $title = 'Payment';
        return view('ecom.web.payment')->with('order', $order)->with('title', $title);
    }

    /**
     * Razorpay payment
     */
    public function razorpay(Request $request)
    {
        // Log::info('razorpay payment request');
        // Log::info($request->all());
        try {
            $input = $request->all();

            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

            $payment = $api->payment->fetch($input['razorpay_payment_id']);
            Log::info($payment);

            if (count($input)  && !empty($input['razorpay_payment_id'])) {

                try {

                    $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                    Log::info($response);
                } catch (Exception $e) {
                    Log::error($e->getMessage());

                    // return  $e->getMessage();

                    return redirect()->back()->with('error', $e->getMessage());
                }
            }

            return redirect()->back()->with('success', 'Payment successful');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Cashfree payment
     */
    public function cashFree1(Request $request)
    {
        // Log::info('cashfree payment request');
        // Log::info($request->all());
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'mobile' => 'required',
            'amount' => 'required'
        ]);

        $url = "https://api.cashfree.com/pg/orders";

        $headers = array(
            "Content-Type: application/json",
            "x-api-version: 2022-01-01",
            "x-client-id: " . env('CASHFREE_API_KEY'),
            "x-client-secret: " . env('CASHFREE_API_SECRET')
        );

        $data = json_encode([
            'order_id' =>  'order_' . rand(1111111111, 9999999999),
            'order_amount' => $validated['amount'],
            "order_currency" => "INR",
            "customer_details" => [
                "customer_id" => 'customer_' . rand(111111111, 999999999),
                "customer_name" => $validated['name'],
                "customer_email" => $validated['email'],
                "customer_phone" => $validated['mobile'],
            ],
            "order_meta" => [
                "return_url" => 'http://127.0.0.1:8000/cashfree/payments/success/?order_id={order_id}&order_token={order_token}'
            ]
        ]);

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $resp = curl_exec($curl);

        curl_close($curl);

        return redirect()->to(json_decode($resp)->payment_link);
    }

    /**
     * Cash on delivery
     */
    public function cod(Request $request)
    {
        // Log::info('cod payment request');
        // Log::info($request->all());
        try {
            $customer = auth('customer')->user();
            $payment_method = paymentMethods($request->paymentMethod);

            $order = Order::find($request->order_id);
            $order->payment_method_id = $payment_method;
            $order->payment_status = 'Unpaid';
            $order->payment_method = 'Cash on delivery';
            $order->status = 'processing';
            $order->save();

            $method = 'Cash on delivery';
            $transaction_id = null;
            $status = 'processing';
            $amount = $order->total;
            $currency = $order->currency;
            $payment_status = 'Unpaid';
            $payment_response = null;
            $payment_date = now();
            $payment_expiry = null;
            $payment_type = 'cod';
            $payment_mode = 'cod';
            $bank = null;
            $card_no = null;
            $card_type = null;
            $card_expiry_month = null;
            $card_expiry_year = null;
            $card_cvv = null;
            $card_holder_name = null;

            // save payment details
            payment($order, $method, $transaction_id, $status, $amount, $currency, $payment_status, $payment_response, $payment_date, $payment_expiry, $payment_type, $payment_mode, $bank, $card_no, $card_type, $card_expiry_month, $card_expiry_year, $card_cvv, $card_holder_name);

            // $order = Order::find($request->order_id);
            $myorder = Order::with('orderItems')->where('id', $order->id)->first();
            // Log::info($myorder->orderItems);
            updateStock($myorder->orderItems);
            // Log::info('orderItems 1 :'.$myorder);


            // delete cart items from database
            Cart::where('customer_id', $customer->id)->delete();

            // empty cart session
            session()->forget('cart');

            // return redirect()->route('shop.index')->with('success', 'Order placed successfully');
            return redirect()->route('shop.thankyou', ['payment_method' => 'cod', 'order_id' => $order->order_number, 'status' => 'success']);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * =============================================================================================
     * =========================================== Cashfree ========================================
     */

    /**
     * Cashfree payment
     */
    public function cashFree(Request $request)
    {
        // Log::info($request->all());
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'mobile' => 'required',
            'amount' => 'required'
        ]);

        $url = "https://api.cashfree.com/pg/orders";

        $headers = [
            "Content-Type" => "application/json",
            "x-api-version" => "2022-01-01",
            "x-client-id" => env('CASHFREE_API_KEY'),
            "x-client-secret" => env('CASHFREE_API_SECRET')
        ];

        $data = [
            'order_id' => $request->order_number,
            'order_amount' => $validated['amount'],
            "order_currency" => "INR",
            "customer_details" => [
                "customer_id" => $request->customer_id,
                "customer_name" => $validated['name'],
                "customer_email" => $validated['email'],
                "customer_phone" => $validated['mobile'],
            ],
            "order_meta" => [
                "return_url" => env('APP_URL') . '/thank-you/?order_id=' . $request->order_number . '&status=success&payment_method=cash_free&order_number=' . $request->order_id
            ]
        ];


        $response = Http::withHeaders($headers)->post($url, $data);

        // Log::info($response->json());
        // Log::info($response['order_id']);

        if ($response->json('order_status') == 'ACTIVE') {
            $customer = auth('customer')->user();
            $payment_method = paymentMethods($request->paymentMethod);

            $order = Order::find($request->order_id);
            $order->payment_method_id = $payment_method;
            $order->payment_status = $response->json('order_status');
            $order->payment_method = 'Online payment';
            $order->status = 'pending';
            $order->save();

            $method = 'Cashfree';
            $transaction_id = $response->json('order_token');
            $status = $response->json('order_status');
            $amount = $order->total;
            $currency = 'INR';
            $payment_status = $response->json('order_status');
            $payment_response = $response->json('order_token');
            $payment_date = now();
            $payment_expiry = null;
            $payment_type = 'online';
            $payment_mode = 'online';

            // save payment details
            payment($order, $method, $transaction_id, $status, $amount, $currency, $payment_status, $payment_response, $payment_date, $payment_expiry, $payment_type, $payment_mode,);
        } else {
            return redirect()->back()->with('error', $response->json('reason'));
        }

        $paymentLink = $response->json('payment_link');

        // $payment_status = $this->getOrderDetails($request->order_number);

        return redirect()->to($paymentLink);
    }

    /**
     * Cashfree payment status check
     */
    public function checkStatus(Request $request)
    {
        // Log::info($request->all());
        $url = "https://api.cashfree.com/pg/orders/" . $request->order_id;

        $headers = [
            "Content-Type" => "application/json",
            "x-api-version" => "2022-01-01",
            "x-client-id" => env('CASHFREE_API_KEY'),
            "x-client-secret" => env('CASHFREE_API_SECRET')
        ];

        $response = Http::withHeaders($headers)->get($url);

        // Log::info($response->json());

        return $response->json();
    }

    /**
     * Get order details
     */
    public function getOrderDetails($orderId)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'x-api-version' => '2023-08-01',
            "Content-Type" => "application/json",
            "x-client-id" => env('CASHFREE_API_KEY'),
            "x-client-secret" => env('CASHFREE_API_SECRET')
        ])->get('https://api.cashfree.com/pg/orders/' . $orderId);

        // Check if the request was successful
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $orderDetails = $response->json();

            // Process the order details as needed
            Log::info(response()->json($orderDetails));

            return response()->json($orderDetails);
        } else {
            // Handle the case where the request failed
            $statusCode = $response->status();
            $errorMessage = $response->json();

            return response()->json(['error' => $errorMessage], $statusCode);
        }
    }

    /**
     * Thank you page
     */
    public function thankyou(Request $request)
    {
        $customer = auth('customer')->user();

        // save payment details
        $order_id = $request->order_id;
        $status = $request->status;
        $title = 'Thank You';

        // Call API to get Order Details
        if ($request->payment_method  == 'cash_free') {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'x-api-version' => '2023-08-01',
                "Content-Type" => "application/json",
                "x-client-id" => env('CASHFREE_API_KEY'),
                "x-client-secret" => env('CASHFREE_API_SECRET')
            ])->get('https://api.cashfree.com/pg/orders/' . $order_id);

            $order_status = $response->json('order_status');

            if ($order_status = 'PAID') {
                // Log::info($order_status);

                // Log::info('order_id :' . $order_id);

                // $order = Order::find($request->order_id);
                $myorder = Order::with('orderItems')->where('order_number', $order_id)->first();
                $myorder->status = 'processing';
                $myorder->save();

                updateStock($myorder->orderItems);


                // delete cart items from database
                Cart::where('customer_id', $customer->id)->delete();

                // empty cart session
                session()->forget('cart');

                $payment = Payment::where('order_id', $request->order_number)->first();

                // change status
                $payment->update([
                    'status' => $order_status,
                    'payment_status'  => $order_status,
                ]);

                $order = Order::find($request->order_number);
                $order->payment_status =  $order_status;
                $order->save();
            } else {
                Log::info($order_status);
                $message = 'Your transaction is failed';
                $status = 'failed';

                // return in thank you page
                return view('ecom.web.thankyou', compact('order_id', 'status', 'title'));
            }

            return view('ecom.web.thankyou', compact('order_id', 'status', 'title'));
            // Log::info(response()->json($response->json('')));
        }

        // return in thank you page
        return view('ecom.web.thankyou', compact('order_id', 'status', 'title'));
    }

    /**
     *
     */
    public function sendRefundRequest($orderId)
    {
        Log::info('order id :' . $orderId);

        // create refund id using random  number
        $refund_id = 'SRV-RF' . Str::random(6);

        // $order = Order::find($orderId);
        // $payment = Payment::where('order_id', $order->id)->first();

        // Log::info($payment);
        // Log::info($payment->amount);

        // $order = Order::find($orderId);
        // $payment = Payment::where('order_id', $order->id)->first();

        // Log::info($payment);
        // Log::info($payment->amount);

        // $order = Order::find($orderId);
        // $payment = Payment::where('order_id', $order->id)->first();

        // Log::info($payment);
        // Log::info($payment->amount);

        // $order = Order::find($orderId);
        // $payment = Payment::where('order_id', $order->id)->first();

        // Log::info($payment);
        // Log::info($payment->amount);

        // $order = Order::find($orderId);';
        $order = Order::with('customer')->where('order_number', $orderId)->first();
        // Log::info('order :' . $order);
        $payment = Payment::where('order_id', $order->id)->first();

        if ($payment->status == "PAID") {
            $url = "https://api.cashfree.com/pg/orders/{$orderId}/refunds";
            $headers = [
                "accept" => "application/json",
                "content-type" => "application/json",
                "x-api-version" => "2023-08-01",
                "x-client-id" => env('CASHFREE_API_KEY'),
                "x-client-secret" => env('CASHFREE_API_SECRET')
            ];
            $data = [
                'order_id' => $order->order_number,
                'refund_amount' => (int)$payment->amount,
                "refund_id" => $refund_id,
            ];

            $response = Http::withHeaders($headers)->post($url, $data);

            Log::info($response->json());

            return redirect()->back()->with('success', 'Refund request sent successfully.');

            // return $response->json();
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Order deleted successfully.',
            // ]);
        } else {
            throw new Exception("Order is not paid yet.");
        }
    }
}
