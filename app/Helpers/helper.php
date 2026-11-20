<?php

// use Request;
// use Illuminate\Support\Facades\Request;
use App\Models\LogActivity as LogActivityModel;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

function changeDateFormate($date, $date_format)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
}

function productImagePath($image_name)
{
    return public_path('images/products/' . $image_name);
}


function addToLog($subject)
{
    $log = [];
    $log['subject'] = $subject;
    $log['url'] = request()->fullUrl();
    $log['method'] = request()->method();
    $log['ip'] = request()->ip();
    $log['agent'] = request()->header('user-agent');
    $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    LogActivityModel::create($log);
}

function storeImage($image, $path)
{
    $image_name = time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path($path), $image_name);
    return $image_name;
}

//store logo image with name logo
function storeLogo($image, $path)
{
    // store logo image
    // if ($request->hasFile('logo')) {
    //     $logo = $request->file('logo');
    //     $logo_name = time() . '.' . $logo->getClientOriginalExtension();
    //     $logo->move(public_path('images/webmaster'), $logo_name);
    //     $request->logo = $logo_name;
    // }

    // $image_name = 'logo' . '.' . $image->getClientOriginalExtension();
    // $image->move(public_path($path), $image_name);

    // Get Extension
    $extension = $image->getClientOriginalExtension();
    $image_name = 'logo' . '.' . $extension;
    $image->move(public_path($path), $image_name);
    $final_name = $path . '/' . $image_name;
    return $final_name;
}

function cart()
{
    try {
        // get cart items from session
        $cart = session()->get('cart', []);

        // get user from session
        $user = Auth::guard('customer')->user();

        if ($user) {
            // Retrieve user cart items
            $user_cart = Cart::where('customer_id', $user->id)->get();

            // Merge user cart items with session cart
            foreach ($user_cart as $item) {
                // Check if the same item is already in session cart
                $existingItemIndex = array_search($item->product_variant_id, array_column($cart, 'product_variant_id'));
                if ($existingItemIndex === false) {
                    // If not, add to cart
                    $quantity = $item->quantity ?? 1; // Set default quantity to 1 if null
                    $cart[] = [
                        'product_id' => $item->product_id,
                        'product_variant_id' => $item->product_variant_id,
                        'ip_address' => $item->ip_address,
                        'name' => $item->name,
                        'image' => $item->image,
                        'quantity' => $quantity,
                        'price' => $item->price,
                        'total' => $quantity * $item->price,
                        'grand_total' => $quantity * $item->price,
                    ];
                }
            }

            // save cart items to database (if necessary)
            foreach ($cart as $item) {
                $db_cart = Cart::where('customer_id', $user->id)->where('product_variant_id', $item['product_variant_id'])->first();
                if (!$db_cart) {
                    $new_cart = new Cart();
                    $new_cart->session_id = session()->getId();
                    $new_cart->ip_address = request()->ip();
                    $new_cart->customer_id = $user->id;
                    $new_cart->product_id = $item['product_id'];
                    $new_cart->product_variant_id = $item['product_variant_id'];
                    $new_cart->name = $item['name'];
                    $new_cart->image = $item['image'];
                    $new_cart->quantity = $item['quantity'];
                    $new_cart->price = $item['price'];
                    $new_cart->total = $item['quantity'] * $item['price'];
                    $new_cart->grand_total = $item['quantity'] * $item['price'];
                    $new_cart->save();
                }
            }
        }

        // save cart items to session
        session()->put('cart', $cart);
    } catch (\Throwable $th) {
        Log::error('Error in cart function: ' . $th->getMessage());
    }
}

function paymentMethods($method)
{
    $methods = [
        'cashfree' => 1,
        'paypal' => 2,
        'stripe' => 3,
        'cod' => 4,
        'debit_card' => 1,
    ];

    // Check if the provided method exists in the array
    if (array_key_exists($method, $methods)) {
        return $methods[$method];
    } else {
        return null; // or throw new Exception("Invalid payment method");
    }
}

function payment($order = null, $method = null, $transaction_id = null, $status = null, $amount = null, $currency = null, $payment_status = null, $payment_response = null, $payment_date = null, $payment_expiry = null, $payment_type = null, $payment_mode = null, $bank = null, $card_no = null, $card_type = null, $card_expiry_month = null, $card_expiry_year = null, $card_cvv = null, $card_holder_name = null)
{
    try {
        $payment = new Payment();
        $payment->customer_id = $order->customer_id;
        $payment->order_id = $order->id;
        $payment->payment_method = $method;
        $payment->transaction_id = $transaction_id;
        $payment->status = $status;
        $payment->amount = $amount;
        $payment->currency = $currency;
        $payment->payment_status = $payment_status;
        $payment->payment_response = $payment_response;
        $payment->payment_date = $payment_date;
        $payment->payment_expiry = $payment_expiry;
        $payment->payment_type = $payment_type;
        $payment->payment_mode = $payment_mode;
        $payment->bank = $bank;
        $payment->card_no = $card_no;
        $payment->card_type = $card_type;
        $payment->card_expiry_month = $card_expiry_month;
        $payment->card_expiry_year = $card_expiry_year;
        $payment->card_cvv = $card_cvv;
        $payment->card_holder_name = $card_holder_name;
        $payment->save();
    } catch (\Throwable $th) {
        Log::error('Error in payment function: ' . $th->getMessage());
    }
}

function updateStock($productItems)
{
    // Log::info($productItems);
    foreach ($productItems as $item) {
        $variant = ProductVariant::find($item->product_variant_id);
        if ($variant != null || $variant != '') {
            // Log::info('variant :' . $variant);
            // update stock  quantity
            // $stockQuantity = (int)$variant->stock - (int)$item->quantity;
            $stockQuantity = (int)$variant->quantity - (int)$item->quantity;
            $variant->stock  =   $stockQuantity;
            $variant->quantity  =   $stockQuantity;
            $variant->save();

            // update Stock
            $stock = Stock::where('product_variant_id', $item->product_variant_id)->first();
            $stock->stock = $stock->stock - $item->quantity;
            $stock->save();

            // Log::info('Quantity :' . $stockQuantity);

            // Log::info('Stock :' . $stock->stock);
        }
    }
}

//========================================= SMS & Whatsapp =========================================//
//==================================================================================================//
function sendSms($phone, $message)
{
    try {
        $mobileNumber = $phone;
        $message =  $message;
        $senderId = getenv("MSGCLUB_SENDER_ID");
        $serverUrl = getenv("MSGCLUB_SERVER_URL");
        $authKey = getenv("MSGCLUB_AUTH_KEY");
        $routeId = getenv("MSGCLUB_SMS_ROUTE");
        $result = sendsmsGET($mobileNumber, $senderId, $routeId, $message, $serverUrl, $authKey);
        // Log::info('sendSms result: ' . $result);
        $result = result($result);
        return $result;
    } catch (\Exception $e) {
        Log::error($e->getMessage());
    }
}

function sendsmsGET($mobileNumber, $senderId, $routeId, $message, $serverUrl, $authKey)
{
    try {
        $route = $routeId;
        $getData = 'mobileNos=' . $mobileNumber . '&message=' . urlencode($message) . '&senderId=' . $senderId . '&routeId=' . $route;

        /* API URL */
        $url = "http://" . $serverUrl . "/rest/services/sendSMS/sendGroupSms?AUTH_KEY=" . $authKey . "&" . $getData;

        /* init the resource */
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        /* get response */
        $output = curl_exec($ch);

        /* Print error if any */
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);

        return $output;
    } catch (\Exception $e) {
        Log::error($e->getMessage());
    }
}

function sendWhatsAppMessage($phone, $message)
{
    $authKey = getenv("MSGCLUB_AUTH_KEY");
    $whatsappNumber = getenv("MSGCLUB_AWHATSAPP_NO");
    $toNumber = $phone;
    $bodyText = $message;

    $url = 'http://msg.msgclub.net/rest/services/sendSMS/v2/sendtemplate?AUTH_KEY=' . $authKey;

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Cookie' => 'JSESSIONID=23BD7D8B4F08B438F9A42E5334C2DDEB.node3',
    ])->post($url, [
        'senderId' => $whatsappNumber,
        'component' => [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $toNumber,
            'type' => 'text',
            'text' => [
                'preview_url' => true,
                'body' => $bodyText,
            ],
        ],
    ]);

    $result = $response->body();
    // Log::info('sendWhatsAppMessage result: ' . $result);
    return result($result);

    return $response->body();
}


function result($result)
{
    $decodedResult = json_decode($result, true); // Assuming $result is a JSON response

    // Check if the responseCode is 3001
    if (isset($decodedResult['responseCode']) && $decodedResult['responseCode'] == '3001') {
        Log::info('Message sent successfully. Response: ' . $result);
        return 'sent';
    } else {
        // Update message status to 'failed'
        Log::error('Error sending message. Response: ' . $result);
        return 'failed';
    }
}
