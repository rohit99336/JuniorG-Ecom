<?php

namespace App\Http\Controllers\Ecom;

use App\Models\Color;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Colors';
            $subTitle = 'List of Colors';
            $colors = Color::all();

            if (request()->ajax()) {
                $colors = Color::with('creater');
                return DataTables::of($colors)
                    ->addColumn('action', function ($color) {
                        return  '<button class="btn btn-primary edit" id="' . $color->id . '"><i class="bx bx-edit-alt "></i></button>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $color->id . '" data-id="' . $color->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->addColumn('creater', function ($color) {
                        return $color->creater->name;
                    })
                    // Show color using color code
                    ->addColumn('color', function ($color) {
                        return '<div style="width: 30px; height: 30px; background-color: ' . $color->code . '"></div>';
                    })
                    ->editColumn('is_active', function ($color) {
                        return $color->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    })
                    ->rawColumns(['action', 'color', 'is_active', 'creater'])
                    ->make(true);
            }
            return view('ecom.admin.colors.index', compact('colors', 'title', 'subTitle'));
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
                'code' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $color = new Color();
            $color->name = $request->name;
            $color->uuid = Uuid::uuid4();
            $color->code = $request->code;
            $color->is_active = $request->status;
            $color->created_by = auth()->guard('ecomadmin')->user()->id;
            $color->save();

            // $color = Color::create([
            //     'name' => $request->name,
            //     'uuid' => $uuid,
            //     'description' => $request->description,
            //     'code' => $request->code,
            //     'is_active' => $request->status,
            //     'created_by' => auth()->guard('ecomadmin')->user()->id,
            // ]);

            if ($color) {
                return redirect()->route('ecomadmin.prod.colors.index')->with('success', 'Color created successfully');
            }
            return redirect()->back()->with('error', 'Color creation failed');
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
            $color = Color::find($id);
            if ($color) {
                return response()->json([
                    'status' => true,
                    'data' => $color,
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Color not found',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
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
                'code' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $color = Color::find($id);
            if ($color) {
                $color->name = $request->name;
                $color->code = $request->code;
                $color->is_active = $request->status;
                $color->updated_by = auth()->guard('ecomadmin')->user()->id;
                $color->save();

                if ($color) {
                    return redirect()->route('ecomadmin.prod.colors.index')->with('success', 'Color updated successfully');
                }
                return redirect()->back()->with('error', 'Color updation failed');
            }
            return redirect()->back()->with('error', 'Color not found');
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
            $color = Color::find($id);
            if ($color) {
                $color->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Color deleted successfully',
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Color not found',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
