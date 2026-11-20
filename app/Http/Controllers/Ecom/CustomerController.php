<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;

use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Order;
use App\Models\State;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Customers';
            $subTitle = 'List of customers';
            $counter = 1;

            $customers = Customer::with('addresses',  'state', 'city', 'deletedBy', 'createdBy', 'updatedBy', 'restoredBy', 'forceDeletedBy')->get();

            if (request()->ajax()) {
                return DataTables::of($customers)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($customer) {
                        return  '<a href="' . route('ecomadmin.customers.show', $customer->id) . '" class="text-primary" title="View customer details"><i class="bx bx-show"></i></a>'  . '&nbsp;&nbsp;<a class="text-danger delete" id="' . $customer->id . '" data-id="' . $customer->id . '" title="Delete customer"><i class="bx bx-trash-alt "></i></a>';

                        // return  '<a href="' . route('ecomadmin.customers.show', $customer->id) . '" class="text-primary" title="View customer details"><i class="bx bx-show"></i></a>' . '&nbsp;&nbsp;<a href="' . route('ecomadmin.customers.edit', $customer->id) . '" class="text-info" title="Edit customer"><i class="bx bx-edit-alt"></i></a>' . '&nbsp;&nbsp;<a class="text-danger delete" id="' . $customer->id . '" data-id="' . $customer->id . '" title="Delete customer"><i class="bx bx-trash-alt "></i></a>';
                    })
                    ->addColumn('created_at', function ($customer) {
                        return date('d-m-Y', strtotime($customer->created_at));
                    })

                    ->rawColumns(['action', 'created_at'])
                    ->make(true);
            }

            return view('ecom.admin.customers.index', compact('customers', 'title', 'subTitle'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $title = 'Customers';
            $subTitle = 'Costomer details';
            $customer = Customer::find($id);
            if (!$customer) {
                return back()->with('error', 'Customer not found.');
            } else if ($customer) {
                // fetch customer customer details
                $customer = customer::where('id', $id)->with('addresses',  'state', 'city', 'deletedBy', 'createdBy', 'updatedBy', 'restoredBy', 'forceDeletedBy', 'defaultAddress')->first();

                // Log::info($customer);
                if (!$customer) {
                    return back()->with('error', 'customer not found.');
                }
            } else {
                return back()->with('error', 'customer not found.');
            }
            return view('ecom.admin.customers.show', compact('customer', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong, please try again.');
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
        try {
            // Get the authenticated customer
            $customer_id = Auth::guard('customer')->user()->id;
            $customer = Customer::findOrFail($customer_id);

            if (!$customer) {
                return redirect()->back()->with('error', 'Customer not found.');
            }

            // Validate the request data
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email',
                    'phone' => 'required|numeric|digits:10',
                    'address' => 'nullable',
                    'zip_code' => 'nullable',
                    'state_id' => 'nullable',
                    'city_id' => 'nullable',
                    'gender' => 'nullable',
                    'dob' => 'nullable|date',
                    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]
            );

            // If validation fails, redirect back with error messages
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Update customer information
            $customer->update([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone2' => $request->phone2,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'gst_number' => $request->gst_number,
                'pan_number' => $request->pan_number,
                'aadhar_number' => $request->aadhar_number,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'pincode_id' => $request->pincode_id,
                'avatar' => $request->avatar,
                'gender' => $request->gender,
                'dob' => $request->dob,
            ]);

            // Update or create the customer's address
            $address = Address::updateOrCreate(
                ['customer_id' => $customer_id, 'type' => 'default'],
                [
                    'first_name' => $customer->name,
                    'last_name' => $customer->last_name,
                    'company' => '',
                    'address' => $request->address,
                    'city' => $request->city_id,
                    'country_id' => 101,
                    'state_id' => $request->state_id,
                    'zip' => $request->zip_code,
                    'phone' => $customer->phone,
                    'type' => 'default',
                ]
            );

            // Update the customer's default address ID
            $customer->update(['default_address_id' => $address->id]);

            // Redirect back with success message
            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            // Log and handle exceptions
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating profile.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $customer = Customer::find($id);
            if ($customer) {
                $customer->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Cutomer deleted successfully.',
                ]);
                // return redirect()->back()->with('success', 'Customer deleted successfully');
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Cutomer deleted successfully.',
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
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        try {
            $customer = Customer::withTrashed()->find($id);
            if ($customer) {
                $customer->restore();
                return redirect()->back()->with('success', 'Customer restored successfully');
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Customer restored successfully.',
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
     * Force delete the specified resource from storage.
     */
    public function forceDelete(string $id)
    {
        try {
            $customer = Customer::withTrashed()->find($id);
            if ($customer) {
                $customer->forceDelete();
                return redirect()->back()->with('success', 'Customer deleted successfully');
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Customer deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.',
            ]);
        }
    }

    //================================== Cutomer Related Methods ===================================//

    /**
     * Customer profile
     */
    public function profile(Request $request)
    {
        try {
            $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
            $coutries = Country::all();
            $states = State::where('country_id', '101')->get();
            $cities = City::where('state_id', '4021')->get();
            $address = Address::where('customer_id', $customer->id)->where('type', 'default')->first();
            $orders = Order::where('customer_id', $customer->id)->with('orderItems', 'orderItems.productVariant')->orderby('id', 'desc');

            $orders = $orders->paginate(10);
            $orders->appends($request->except('page'));

            $title = 'My Account';

            return view('ecom.web.customer.profile', compact('customer', 'coutries', 'states', 'cities', 'address', 'orders', 'title'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function orderDetail(string $id)
    {
        try {
            $customer = Customer::find(auth('customer')->user()->id);
            $title = 'Order Details';
            if (!$customer) {
                return back()->with('error', 'Customer not found.');
            } else if ($customer) {

                // fetch customer order details
                $order = Order::where('order_number', $id)->where('customer_id', $customer->id)->with('orderItems', 'orderItems.productVariant', 'shippingAddress', 'billingAddress')->first();

                if (!$order) {
                    return back()->with('error', 'Order not found.');
                }
            } else {
                return back()->with('error', 'Order not found.');
            }
            return view('ecom.web.customer.order-detail', compact('order', 'title'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong, please try again.');
        }
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|min:6',
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6|same:password',
            ]);

            // return all errors
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
            if ($customer) {
                if (Hash::check($request->old_password, $customer->password)) {
                    $customer->password = Hash::make($request->password);
                    $customer->save();

                    return redirect()->back()->with('success', 'Password Changed Successfully');
                } else {
                    return redirect()->back()->with('error', 'Old Password Not Matched');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid Token');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
