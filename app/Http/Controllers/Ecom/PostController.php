<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Post';
        $subTitle = 'List of Posts';
        $counter = 1;

        if (request()->ajax()) {
            $posts = Post::with('approvedBy', 'customer');
            // Log::info($posts->get());
            return DataTables::of($posts)
                ->addColumn('sr_no', function () use (&$counter) {
                    return $counter++;
                })
                ->addColumn('action', function ($post) {
                    return  '<a href="' . route('ecomadmin.posts.show', $post->id) . '"  class="btn btn-info show"><i class="bx bx-show "></i></a>' . '&nbsp;&nbsp;<a href="' . route('ecomadmin.posts.edit', $post->id) . '"  class="btn btn-primary show"><i class="bx bx-edit-alt "></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $post->id . '" data-id="' . $post->id . '"><i class="bx bx-trash-alt "></i></button>';
                })
                ->addColumn('customer', function ($post) {
                    return ucfirst($post->customer->name) . ' ' . ucfirst($post->customer->last_name);
                })
                ->addColumn('approved_by', function ($post) {
                    if ($post->approvedBy) {
                        return ucfirst($post->approvedBy->name);
                    } else {
                        return "Not Approved";
                    }
                })
                ->addColumn('post_status', function ($post) {
                    return '<select class="form-select" aria-label="Default select example" onchange="changeStatus(this, ' . $post->id . ')">
                                <option value="' . $post->status . '" selected>' . ucfirst($post->status) . '</option>
                                <option value="approved">Approved</option>
                                <option value="blocked">Blocked</option>
                                <option value="released">Released</option>
                            </select>';
                })
                ->addColumn('approve_at', function ($post) {
                    if ($post->approvedBy) {
                        return date('d-m-Y', strtotime($post->approve_at));
                    } else {
                        return "Not Approved";
                    }
                })
                ->rawColumns(['sr_no', 'action', 'customer', 'approved_by', 'post_status', 'approve_at'])
                ->make(true);
        }
        return view('ecom.admin.posts.index', compact('title', 'subTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $title = 'New Post';
            $user = auth()->guard('customer')->user();

            if ($user) {
                return view('ecom.web.new-post', compact('title'));
            } else {
                return redirect()->route('shop.login')->with('error', 'Please login to create a new post');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'postTitle' => 'required',
                'content' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = auth()->guard('customer')->user();

            if ($user) {
                $post = new Post();
                $post->title = $request->postTitle;
                $post->body = $request->content;
                $post->customer_id = $user->id;
                $post->save();
                return redirect()->route('shop.index')->with('success', 'Post submited successfully');
            } else {
                return redirect()->route('shop.login')->with('error', 'Please login to create a new post');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $title = 'Posts';
            $subTitle = 'Post Detail';
            $user = auth()->guard('customer')->user();
            $post = Post::find($id);

            return view('ecom.admin.posts.show', compact('post', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $title = 'Posts';
            $subTitle = 'Edit Post';
            $user = auth()->guard('customer')->user();
            $post = Post::find($id);

            return view('ecom.admin.posts.edit', compact('post', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'postTitle' => 'required',
                'content' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = auth()->guard('customer')->user();

            $post = Post::find($id);
            if ($user) {
                $post->title = $request->postTitle;
                $post->body = $request->content;
                $post->customer_id = $user->id;
                $post->save();
                return redirect()->route('ecomadmin.posts.index')->with('success', 'Post updated successfully');
            } else {
                return redirect()->route('ecomLogin')->with('error', 'Please login to edit post');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $post = Post::find($id);
            $post->delete();
            return response()->json([
                'message' => 'Post deleted successfully',
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }

    //=================================================================================================/
    /**
     * Update status
     */
    public function updateStatus(Request $request)
    {
        try {
            $admin = auth()->guard('ecomadmin')->user();
            $post = Post::find($request->post_id);
            $post->status = $request->status;
            $post->approved_by = $admin->id;
            $post->approve_at = date('Y-m-d H:i:s');
            $post->save();
            return response()->json([
                'message' => 'Status updated successfully',
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }

    /**
     * Store the post comment for the specified post.
     */
    public function storeComment(Request $request)
    {
        Log::info($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'comment' => 'required',
                'post_id' => 'required',
                'parent_id' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = auth()->guard('customer')->user();

            if ($user) {
                $postComment = new PostComment();
                $postComment->comment = $request->comment;
                $postComment->post_id = $request->post_id;
                $postComment->customer_id = $user->id;
                $postComment->parent_id = $request->parent_id ?? null;
                $postComment->save();
                // return redirect()->route('shop.index')->with('success', 'Comment submited successfully');

                $comment = PostComment::with('customer')->where('id', $postComment->id)->first();
                // Log::info($comment);

                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'comment' => $postComment,
                    'message' => 'Comment submited successfully'
                ]);
            } else {
                // return redirect()->route('shop.login')->with('error', 'Please login to create a new post');

                return response()->json([
                    'success' => false,
                    'code' => 400,
                    'message' => 'Please login to comment a post',
                    'url' => 'shop.login',
                    'route' => 'shop.login',
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }
}
