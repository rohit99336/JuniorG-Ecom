<?php

namespace App\Http\Controllers\Ecom;

use App\Models\BlogCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BlogCtargoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Blog Categories';
            $subTitle = 'List of blog categories';
            $blogs = BlogCategory::all();
            $counter = 1;

            if (request()->ajax()) {
                $blogs = BlogCategory::with('parent', 'parent', 'children');
                return DataTables::of($blogs)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($blogs) {
                        return  '<a href="' . route('ecomadmin.blog.blog-category.edit', $blogs->id) . '"  class="btn btn-primary show"><i class="bx bx-edit-alt "></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $blogs->id . '" data-id="' . $blogs->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}')
                    ->editColumn('updated_at', '{{ date("d-m-Y", strtotime($updated_at)) }}')
                    ->rawColumns(['action', 'created_at', 'updated_at', 'sr_no'])
                    ->make(true);
            }
            return view('ecom.admin.blogCategories.index', compact('blogs', 'title', 'subTitle'));
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
            $title = 'Blog Categories';
            $subTitle = 'Add New Blog Category';
            $categories = BlogCategory::whereNull('parent_id')->get();
            return view('ecom.admin.blogCategories.create', compact('title', 'subTitle', 'categories'));
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
                'name' => 'required|unique:blog_categories,name', // column name to be unique except current id
                'description' => 'nullable',
                // 'image' => 'nullable',
                'parent_id' => 'nullable',
                // 'icon' => 'required',
                // 'status' => 'required|in:0,1',
                'slug' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $category = BlogCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image,
                'parent_id' => $request->parent_id,
                'slug' => $request->slug ?? $request->name,
                // 'icon' => $request->icon,
            ]);

            if ($category) {
                return redirect()->route('ecomadmin.blog.blog-category.index')->with('success', 'Blog category created successfully');
            }
            return redirect()->back()->with('error', 'Blog category creation failed');
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
            $title = 'Blog Categories';
            $subTitle = 'Edit Blog Category';
            $category = BlogCategory::find($id);
            $categories = BlogCategory::whereNull('parent_id')->get();
            return view('ecom.admin.blogCategories.edit', compact('title', 'subTitle', 'categories', 'category'));
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
                'name' => 'required|unique:blog_categories,name' . $request->id, // column name to be unique except current id
                'description' => 'nullable',
                // 'image' => 'nullable',
                'parent_id' => 'nullable',
                // 'icon' => 'required',
                // 'status' => 'required|in:0,1',
                'slug' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $category = BlogCategory::find($id);
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image,
                'parent_id' => $request->parent_id,
                'slug' => $request->slug ?? $request->name,
                // 'icon' => $request->icon,
            ]);

            if ($category) {
                return redirect()->route('ecomadmin.blog.blog-category.index')->with('success', 'Blog category created successfully');
            }
            return redirect()->back()->with('error', 'Blog category creation failed');
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
            $bolgCategory = BlogCategory::find($id);
            if ($bolgCategory) {
                $bolgCategory->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Blog category deleted successfully.',
                ]);
            } else {
                // return redirect()->back()->withErrors(['msg' => 'No such blog found']);
                return response()->json([
                    'status' => 'error',
                    'errors' => ['msg' => 'No such blog found.'],
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.',
            ]);
        }
    }
}
