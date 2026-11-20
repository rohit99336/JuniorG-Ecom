<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcomAdmin;
// use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Employees';
            $subTitle = 'List of employees';
            $counter = 1;

            if (request()->ajax()) {
                $employees = EcomAdmin::with('createdBy', 'updatedBy');
                // $currentUser = auth()->user();

                // $employees = EcomAdmin::with('createdBy', 'updatedBy')
                //     ->where('id', '!=', $currentUser->id); // Exclude the logged-in user

                return DataTables::of($employees)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($employee) {
                        return  '<a href="' . route('ecomadmin.employees.edit', $employee->id) . '" class="btn btn-info"><i class="bx bx-edit-alt"></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $employee->id . '" data-id="' . $employee->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->editColumn('created_at', function ($employee) {
                        return $employee->created_at->format('d-M-Y');
                    })
                    ->addColumn('created_by', function ($employee) {
                        if ($employee->createdBy && $employee->createdBy->name) {
                            return ucfirst($employee->createdBy->name);
                        } else {
                            return 'Unknown'; // Or any default value you want to display
                        }
                    })

                    ->rawColumns(['action', 'created_by', 'created_at'])
                    ->make(true);
            }
            return view('ecom.admin.employees.index', compact('title', 'subTitle'));
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
            $title = 'Employee';
            $subTitle = 'New employee';
            // $roles = Role::all();
            $roles = Role::pluck('name', 'name')->all();
            return view('ecom.admin.employees.create', compact('title', 'subTitle', 'roles'));
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
                'name' => 'required|string|max:255|min:3',
                'email' => 'required|string|email|max:255|unique:ecom_admins',
                'password' => 'required|min:6',
                'phone' => 'required|numeric|digits:10|unique:ecom_admins',
                'phone2' => 'nullable|numeric|digits:10',
                'address' => 'string|max:255|min:3|nullable',
                'state_id' => 'numeric|nullable',
                'city_id' => 'numeric|nullable',
                'pincode_id' => 'numeric|nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $employee = EcomAdmin::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone2' => $request->phone2,
                'address' => $request->address,
                'employee_id' => 'EMP' . rand(100000, 999999),
                'password' => Hash::make($request->password),
                'created_by' => auth()->guard('ecomadmin')->user()->id,
                // 'updated_by' => auth()->guard('ecomadmin')->user()->id,
            ]);

            $employee->assignRole($request->roles);

            if ($employee) {
                return redirect()->route('ecomadmin.employees.index')
                    ->with('success', 'Employee created successfully');
            }

            return redirect()->back()->with('error', 'Employee creation failed');
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
            $title = 'Employee';
            $subTitle = 'Edit employee';
            $roles = Role::all();
            $employee = EcomAdmin::with('roles')->find($id);
            return view('ecom.admin.employees.edit', compact('title', 'subTitle', 'roles', 'employee'));
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
                'name' => 'required|string|max:255|min:3',
                'email' => 'required|string|email|max:255|unique:ecom_admins,email,' . $id,
                // 'password' => 'required|min:6',
                'phone' => 'required|numeric|digits:10|unique:ecom_admins,phone,' . $id,
                'phone2' => 'nullable|numeric|digits:10',
                'address' => 'string|max:255|min:3|nullable',
                'state_id' => 'numeric|nullable',
                'city_id' => 'numeric|nullable',
                'pincode_id' => 'numeric|nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $employee = EcomAdmin::find($id);

            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone2' => $request->phone2,
                'address' => $request->address,
                'roles' => $request->roles,
                // 'employee_id' => 'EMP' . rand(100000, 999999),
                // 'password' => Hash::make($request->password),
                // 'created_by' => auth()->guard('ecomadmin')->user()->id,
                'updated_by' => auth()->guard('ecomadmin')->user()->id,
            ]);

            DB::table('model_has_roles')->where('model_id', $id)->delete();

            $employee->assignRole($request->input('roles'));

            if ($employee) {
                return redirect()->route('ecomadmin.employees.index')
                    ->with('success', 'Employee created successfully');
            }

            return redirect()->back()->with('error', 'Employee creation failed');
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
            $ecomAdmin = auth('ecomadmin')->user();
            $employee = EcomAdmin::find($id);
            $employee->delete();

            // employee deleted by
            $employee->deleted_by = $ecomAdmin->id;
            $employee->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Employee deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.',
            ]);
        }
    }


    // ===================================== Advance ====================================//
    /**
     * Get all deleted employees
     */
    public function getDeletedEmployees()
    {
        try {
            $title = 'Employees';
            $subTitle = 'Deleted employees';
            $counter = 1;

            if (request()->ajax()) {
                $employees = EcomAdmin::onlyTrashed()->with('createdBy', 'updatedBy');
                return DataTables::of($employees)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($employee) {
                        return  '<button class="btn btn-success restore" id="' . $employee->id . '" data-id="' . $employee->id . '"><i class="bx bx-undo"></i></button>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $employee->id . '" data-id="' . $employee->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->editColumn('created_at', function ($employee) {
                        return $employee->created_at->format('d-M-Y');
                    })
                    ->addColumn('created_by', function ($employee) {
                        if ($employee->createdBy && $employee->createdBy->name) {
                            return ucfirst($employee->createdBy->name);
                        } else {
                            return 'Unknown'; // Or any default value you want to display
                        }
                    })

                    ->rawColumns(['action', 'created_by', 'created_at'])
                    ->make(true);
            }
            return view('ecom.admin.employees.index', compact('title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Restore a deleted employee
     */
    public function restoreEmployee($id)
    {
        try {
            $employee = EcomAdmin::onlyTrashed()->find($id);
            $employee->restore();

            return response()->json([
                'status' => 'success',
                'message' => 'Employee restored successfully.',
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
     * Permanently delete a deleted employee
     */
    public function deleteEmployee($id)
    {
        try {
            $employee = EcomAdmin::onlyTrashed()->find($id);
            $employee->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'Employee permanently deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.',
            ]);
        }
    }
}
