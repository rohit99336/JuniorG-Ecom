<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\Category;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Categories';
            $subTitle = 'List of categories';
            $categories = Category::all();

            if (request()->ajax()) {
                $categories = Category::with('parent');
                return Datatables::of($categories)
                    ->addColumn('action', function ($category) {
                        return  '<a href="' . route('ecomadmin.prod.categories.edit', $category->id) . '"  class="btn btn-primary show"><i class="bx bx-edit-alt "></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $category->id . '" data-id="' . $category->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->editColumn('image', function ($category) {
                        return '<img src="' . $category->image . '" alt="' . $category->name . '" width="70" height="70">';
                    })
                    ->editColumn('parent_id', function ($category) {
                        return $category->parent ? $category->parent->name : '';
                    })
                    ->editColumn('is_active', function ($category) {
                        return $category->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    })
                    // ->addColumn('no_of_variants', function ($category) {
                    //     return $category->categoryVariants->count();
                    // })
                    // ->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}')
                    // ->editColumn('updated_at', '{{ date("d-m-Y", strtotime($updated_at)) }}')
                    ->rawColumns(['action', 'image', 'is_active', 'parent_id'])
                    ->make(true);
            }
            return view('ecom.admin.categories.index', compact('categories', 'title', 'subTitle'));
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
            $title = 'Categories';
            $subTitle = 'Create category';
            $categories = Category::all();
            return view('ecom.admin.categories.create', compact('categories', 'title', 'subTitle'));
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
                'description' => 'nullable',
                'image' => 'nullable',
                'parent_id' => 'nullable',
                'icon' => 'required',
                'status' => 'required|in:0,1',
                'meta_title' => 'nullable',
                'meta_description' => 'nullable',
                'meta_keywords' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $category = Category::create([
                'uuid' => Uuid::uuid4(),
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image,
                'parent_id' => $request->parent_id,
                'icon' => $request->icon,
                'is_active' => $request->status,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]);

            if ($category) {
                return redirect()->route('ecomadmin.prod.categories.index')->with('success', 'Category created successfully');
            }
            return redirect()->back()->with('error', 'Category creation failed');
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
            $title = 'Categories';
            $subTitle = 'Edit category';
            $categories = Category::all();
            $category = Category::find($id);
            return view('ecom.admin.categories.edit', compact('categories', 'category', 'title', 'subTitle'));
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
                'name' => 'required',
                'description' => 'nullable',
                'image' => 'nullable',
                'parent_id' => 'nullable',
                'icon' => 'nullable',
                'meta_title' => 'nullable',
                'meta_description' => 'nullable',
                'meta_keywords' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $category = Category::find($id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->image = $request->image;
            $category->parent_id = $request->parent_id;
            $category->icon = $request->icon;
            $category->is_active = $request->status;
            $category->meta_title = $request->meta_title;
            $category->meta_description = $request->meta_description;
            $category->meta_keywords = $request->meta_keywords;
            $category->save();

            if ($category) {
                return redirect()->route('ecomadmin.prod.categories.index')->with('success', 'Category updated successfully');
            }
            return redirect()->back()->with('error', 'Category updation failed');
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
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                // return redirect()->route('ecomadmin.prod.categories.index')->with('success', 'Category deleted successfully');
                return response()->json(['success' => 'Category deleted successfully']);
            }
            return redirect()->back()->with('error', 'Category deletion failed');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
