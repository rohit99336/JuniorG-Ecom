<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        try {
            $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
            $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
            $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
            $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        } catch (\Exception $e) {
            Log::error('Error in constructor: ' . $e->getMessage());
            // Handle or log the exception
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $title = 'Roles';
            $subTitle = 'List of roles';
            $counter = 1;

            // Log::info('User ' . auth()->user()->name . ' is viewing permissions');

            if (request()->ajax()) {
                $roles = Role::with('createdBy', 'updatedBy');
                return DataTables::of($roles)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($role) {
                        return  '<a href="' . route('ecomadmin.authorization.roles.edit', $role->id) . '" class="btn btn-info"><i class="bx bx-edit-alt"></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $role->id . '" data-id="' . $role->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->editColumn('created_at', function ($role) {
                        return $role->created_at->format('d-M-Y h:i A');
                    })
                    ->addColumn('created_by', function ($role) {
                        return ucfirst($role->createdBy->name);
                    })

                    ->rawColumns(['action', 'created_by', 'created_at'])
                    ->make(true);
            }
            return view('ecom.admin.roles.index', compact('title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $title = 'Roles';
            $subTitle = 'List of roles';
            $permissions = Permission::get();
            return view('ecom.admin.roles.create', compact('permissions', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error('Error in create method: ' . $e->getMessage());
            // Handle or log the exception
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Log::info($request->all());
        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ]);

            $admin = auth()->guard('ecomadmin')->user();
            $role = Role::create([
                'name' => $request->input('name'),
                'guard_name' => 'ecomadmin',
                'created_by' => $admin->id,
            ]);
            $role->syncPermissions($request->input('permission'));

            return redirect()->route('ecomadmin.authorization.roles.index')->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            // Handle or log the exception
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $role = Role::find($id);
            $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
                ->where("role_has_permissions.role_id", $id)
                ->get();

            return view('ecom.admin.roles.show', compact('role', 'rolePermissions'));
        } catch (\Exception $e) {
            Log::error('Error in show method: ' . $e->getMessage());
            // Handle or log the exception
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $title = 'Roles';
            $subTitle = 'Edit role';
            $role = Role::find($id);
            $permission = Permission::get();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();

            return view('ecom.admin.roles.edit', compact('role', 'permission', 'rolePermissions', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error('Error in edit method: ' . $e->getMessage());
            // Handle or log the exception
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'permission' => 'required',
            ]);

            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->guard_name = 'ecomadmin';
            $role->updated_by = auth()->guard('ecomadmin')->user()->id;
            $role->save();

            $role->syncPermissions($request->input('permission'));

            return redirect()->route('ecomadmin.authorization.roles.index')->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            Log::error('Error in update method: ' . $e->getMessage());
            // Handle or log the exception
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // try {
        //     DB::table("roles")->where('id', $id)->delete();
        //     return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
        // } catch (\Exception $e) {
        //     Log::error('Error in destroy method: ' . $e->getMessage());
        //     // Handle or log the exception
        // }

        try {
            $role = DB::table("roles")->where('id', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }
}
