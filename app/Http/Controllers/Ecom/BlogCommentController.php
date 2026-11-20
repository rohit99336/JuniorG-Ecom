<?php

namespace App\Http\Controllers\Ecom;

use App\Models\Blog;
use App\Models\BlogComment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Rules\ReCaptcha;

class BlogCommentController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log::info($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'email' => 'required',
                'blog_id' => 'required|exists:blogs,id',
                'comment' => 'required',
                // 'g-recaptcha-response' => ['required', new ReCaptcha],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $comment = new BlogComment($request->only(['first_name', 'last_name', 'email', 'blog_id', 'category_id', 'comment']));
            $comment->save();

            return redirect()->back()->with('success', 'Your comment send successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
