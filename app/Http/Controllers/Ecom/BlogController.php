<?php

namespace App\Http\Controllers\Ecom;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Blogs';
            $subTitle = 'List of blogs';
            $blogs = Blog::all();
            $counter = 1;

            if (request()->ajax()) {
                $blogs = Blog::with('createdby');
                return DataTables::of($blogs)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($blogs) {
                        return  '<a href="' . route('ecomadmin.blog.blogs.edit', $blogs->id) . '"  class="btn btn-primary show"><i class="bx bx-edit-alt "></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $blogs->id . '" data-id="' . $blogs->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    // ->editColumn('image', function ($blogs) {
                    //     return '<img src="' . $blogs->image . '" alt="' . $blogs->name . '" width="70" height="70">';
                    // })
                    ->editColumn('created_by', function ($blogs) {
                        return $blogs->createdby ? $blogs->createdby->name  : '';
                    })
                    // ->editColumn('is_active', function ($blogs) {
                    //     return $blogs->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    // })
                    // ->addColumn('no_of_variants', function ($blogs) {
                    //     return $blogs->blogsVariants->count();
                    // })
                    ->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}')
                    ->editColumn('updated_at', '{{ date("d-m-Y", strtotime($updated_at)) }}')
                    ->rawColumns(['action', 'created_by', 'created_at', 'updated_at', 'sr_no'])
                    ->make(true);
            }
            return view('ecom.admin.blogs.index', compact('blogs', 'title', 'subTitle'));
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
            $title = 'Blogs';
            $subTitle = 'New Blog';
            $categories = BlogCategory::all();
            return view('ecom.admin.blogs.create', compact('title', 'subTitle', 'categories'));
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
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required|exists:blog_categories,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $tags = $request->tag ? explode(',', $request->tag) : [];

            foreach ($tags as $t) {
                if (!BlogTag::where('name', $t)->exists()) {
                    BlogTag::create(['name' => $t, 'slug' => $t]);
                }
            }

            $blog = new Blog($request->only(['title', 'content', 'meta_keywords', 'meta_description', 'category_id', 'tag', 'thumbnail_img']));
            // $blog->tag = $tags;
            $blog->created_by = auth()->guard('ecomadmin')->id();
            $blog->save();

            return redirect()->route('ecomadmin.blog.blogs.index')->with('success', 'Blog created successfully.');
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
            $title = 'Blogs';
            $subTitle = 'Edit Blog';
            $categories = BlogCategory::all();
            $blog = Blog::find($id);
            return view('ecom.admin.blogs.edit', compact('title', 'subTitle', 'blog', 'categories'));
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
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required|exists:blog_categories,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $tags = $request->tag ? explode(',', $request->tag) : [];

            foreach ($tags as $t) {
                if (!BlogTag::where('name', $t)->exists()) {
                    BlogTag::create(['name' => $t, 'slug' => $t]);
                }
            }

            $blog = Blog::find($id);
            $blog->update($request->only(['title', 'content', 'meta_keywords', 'meta_description', 'category_id', 'tag', 'thumbnail_img']));
            // $blog->tag = $request->tag;
            $blog->save();

            return redirect()->route('ecomadmin.blog.blogs.index')->with('success', 'Blog updated successfully.');
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
            $bolg = Blog::find($id);
            if ($bolg) {
                $bolg->delete();
                // return redirect()->back()->with('success', 'Blog deleted successfully');
                return response()->json([
                    'status' => 'success',
                    'message' => 'Blog deleted successfully.',
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
