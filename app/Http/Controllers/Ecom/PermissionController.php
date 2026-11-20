<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Permissions';
            $subTitle = 'List of permissions';
            $permissons = Permission::all();
            $counter = 1;

            if (request()->ajax()) {
                $permissons = Permission::with('createdBy', 'updatedBy');
                return DataTables::of($permissons)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($permissons) {
                        return  '<a href="' . route('ecomadmin.authorization.permissions.edit', $permissons->id) . '" class="btn btn-info"><i class="bx bx-edit-alt"></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $permissons->id . '" data-id="' . $permissons->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->editColumn('created_at', function ($permissons) {
                        return $permissons->created_at->format('d-M-Y h:i A');
                    })
                    ->addColumn('created_by', function ($permissons) {
                        return ucfirst($permissons->createdBy->name);
                    })

                    ->rawColumns(['action', 'created_by', 'created_at'])
                    ->make(true);
            }
            return view('ecom.admin.permissions.index', compact('permissons', 'title', 'subTitle'));
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
            $title = 'Permissions';
            $subTitle = 'New permissions';
            $roles = Role::all();
            return view('ecom.admin.permissions.create', compact('title', 'subTitle', 'roles'));
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
            $admin = auth()->guard('ecomadmin')->user();

            $validator = Validator::make($request->all(), [
                'name' => 'string|required',
                'guard_name' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            Permission::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
                'created_by' => $admin->id,
                // 'customer_id' => auth()->guard('customer')->user()->id,
            ]);

            return back()->with('success', 'Permission created successfully');
        } catch (\Exception $e) {
            Log::error("Error on add permission : " . $e->getMessage());
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

            $title = 'Permissions';
            $subTitle = 'Edit permissions';
            $permission = Permission::find($id);
            $roles = Role::all();
            return view('ecom.admin.permissions.edit', compact('title', 'subTitle', 'permission', 'roles'));
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
            $admin = auth()->guard('ecomadmin')->user();

            $validator = Validator::make($request->all(), [
                'name' => 'string|required',
                'guard_name' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->updated_by = $admin->id;
            $permission->save();

            return back()->with('success', 'Permission updated successfully');
        } catch (\Exception $e) {
            Log::error("Error on update permission : " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $permission = Permission::find($id);
            $permission->delete();
            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }
}
