<?php

namespace App\Http\Controllers\Ecom;

use App\Models\Unit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Units';
            $subTitle = 'List of Units';
            $units = Unit::all();

            if (request()->ajax()) {
                $units = Unit::with('creater');
                return Datatables::of($units)
                    ->addColumn('action', function ($unit) {
                        return  '<button class="btn btn-primary edit" id="' . $unit->id . '"><i class="bx bx-edit-alt "></i></button>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $unit->id . '" data-id="' . $unit->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->addColumn('creater', function ($unit) {
                        return $unit->creater->name;
                    })
                    ->editColumn('is_active', function ($unit) {
                        return $unit->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    })
                    ->rawColumns(['action', 'image', 'is_active', 'creater'])
                    ->make(true);
            }
            return view('ecom.admin.units.index', compact('units', 'title', 'subTitle'));
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
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'nullable',
                'short_name' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $unit = Unit::create([
                'name' => $request->name,
                'description' => $request->description,
                'short_name' => $request->short_name,
                'is_active' => $request->status,
                'created_by' => auth()->guard('ecomadmin')->user()->id,
            ]);

            if ($unit) {
                return redirect()->route('ecomadmin.prod.units.index')->with('success', 'Unit created successfully');
            }
            return redirect()->back()->with('error', 'Unit creation failed');
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
            $unit = Unit::find($id);
            return response()->json([
                'status' => 'success',
                'data' => $unit
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'nullable',
                'short_name' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $unit = Unit::find($id);
            $unit->name = $request->name;
            $unit->description = $request->description;
            $unit->short_name = $request->short_name;
            $unit->is_active = $request->status;
            // $unit->updated_by = auth()->guard('ecomadmin')->user()->id;
            $unit->save();

            if ($unit) {
                return redirect()->route('ecomadmin.prod.units.index')->with('success', 'Unit updated successfully');
            }
            return redirect()->back()->with('error', 'Unit updation failed');
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
            $unit = Unit::find($id);
            if ($unit) {
                $unit->delete();
                // return redirect()->route('ecomadmin.prod.units.index')->with('success', 'Unit deleted successfully');
                return response()->json(['success' => 'Unit deleted successfully']);
            }
            return redirect()->back()->with('error', 'Unit deletion failed');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
