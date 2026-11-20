<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;


class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Payment Methods';
            $subTitle = 'List of payment methods';
            $payment_methods = PaymentMethod::all();
            $counter = 1;

            if (request()->ajax()) {
                $payment_methods = PaymentMethod::select('*');
                return Datatables::of($payment_methods)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($payment_methods) {
                        return  '<a href="' . route('ecomadmin.setting.payment-methods.edit', $payment_methods->id) . '" class="btn btn-info"><i class="bx bx-edit-alt"></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $payment_methods->id . '" data-id="' . $payment_methods->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    // ->editColumn('created_at', function ($payment_methods) {
                    //     return $payment_methods->created_at->format('d-M-Y h:i A');
                    // })
                    ->editColumn('description', function ($payment_methods) {
                        // return $payment_methods->description ? $payment_methods->description : 'N/A';

                        // add after 30 words ...
                        $string = strip_tags($payment_methods->description);
                        if (strlen($string) > 30) {
                            // truncate string
                            $stringCut = substr($string, 0, 30);
                            $endPoint = strrpos($stringCut, ' ');
                            //if the string doesn't contain any space then it will cut without word basis.
                            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                            $string .= '...';
                        }
                        return $string;

                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('ecom.admin.paymentMethods.index', compact('payment_methods', 'title', 'subTitle'));
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
            $title = 'Payment methods';
            $subTitle = 'Create payment method';
            return view('ecom.admin.paymentMethods.create', compact('title', 'subTitle'));
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
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $payment_method = new PaymentMethod();
            $payment_method->name = $request->name;
            $payment_method->slug = Uuid::uuid4()->toString();
            $payment_method->description = $request->description;
            $payment_method->save();

            if ($payment_method) {
                return redirect()->route('ecomadmin.setting.payment-methods.index')->with('success', 'Payment method created successfully');
            }
            return redirect()->back()->with('error', 'Payment method creation failed');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        try {
            $title = 'Payment methods';
            $subTitle = 'Payment method details';
            return view('ecom.admin.paymentMethods.show', compact('paymentMethod', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        try {
            $title = 'Payment methods';
            $subTitle = 'Edit payment method';
            return view('ecom.admin.paymentMethods.edit', compact('paymentMethod', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'slug' => 'nullable',
                'description' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $paymentMethod->name = $request->name;
            $paymentMethod->slug = Uuid::uuid4()->toString();
            $paymentMethod->description = $request->description;
            $paymentMethod->save();

            if ($paymentMethod) {
                return redirect()->route('ecomadmin.setting.payment-methods.index')->with('success', 'Payment method updated successfully');
            }
            return redirect()->back()->with('error', 'Payment method updation failed');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        try {
            $paymentMethod->delete();
            // return redirect()->route('ecomadmin.setting.payment-methods.index')->with('success', 'Payment method deleted successfully');

            return response()->json([
                'success' => true,
                'message' => 'Payment method deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Payment method deletion failed');
        }
    }
}
