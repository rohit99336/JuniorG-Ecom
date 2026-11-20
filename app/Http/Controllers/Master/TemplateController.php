<?php

namespace App\Http\Controllers\Master;

use App\Models\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $templates = Template::paginate(10);
            $templates->appends($request->except('page'));

            return view('master.templates.index', compact('templates'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('master.templates.create');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Something went wrong!');
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
                'message' => 'required',
                'media_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add appropriate validation for media_file
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('media_file')) {
                $image = $request->file('media_file');
                $imageName = time() . '_' . $image->getClientOriginalName();

                $path = 'template/img/' . $imageName;
                $image_path = public_path('template/img/' . $imageName);
                $image->move(public_path('template/img/'), $imageName);
            }

            $template = Template::create([
                'msg_temp_id' => $request->input('template_id', ''),
                'name' => $request->input('name', ''),
                'subject' => $request->input('subject', ''),
                'message' => $request->input('message', ''),
                'media_file' => $path ?? '',
                'type' => $request->input('type', ''),
                'status' => $request->input('status', ''),
                'event_name' => $request->input('event_name', ''),
                'cc' => $request->input('cc', ''),
                'bcc' => $request->input('bcc', ''),
            ]);

            return redirect()->route('templates.index')->with('success', 'Template created successfully!');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Something went wrong!');
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
            $template = Template::findOrFail($id);

            return view('master.templates.edit', compact('template'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Something went wrong!');
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
                'message' => 'required',
                'media_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $template = Template::findOrFail($id);

            if ($request->hasFile('media_file')) {
                if (!empty($template->media_file)) {
                    unlink(public_path($template->media_file));
                }

                $image = $request->file('media_file');
                $imageName = time() . '_' . $image->getClientOriginalName();

                $path = 'template/img/' . $imageName;
                $image_path = public_path('template/img/' . $imageName);
                $image->move(public_path('template/img/'), $imageName);
            } else {
                $path = $template->media_file;
            }

            $template->update([
                'name' => $request->name ?? '',
                'media_file' => $path ?? '',
                'cc' => $request->cc ?? $template->cc,
                'bcc' => $request->bcc ?? $template->bcc,
                'msg_temp_id' => $request->template_id ?? $template->msg_temp_id,
                'subject' => $request->subject ?? $template->subject,
                'message' => $request->message ?? $template->message,
                'type' => $request->type ?? $template->type,
                'status' => $request->status ?? $template->status,
                'event_name' => $request->event_name ?? $template->event_name,
            ]);

            return redirect()->route('templates.index')->with('success', 'Template updated successfully!');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $template = Template::findOrFail($id);

            // check if media_file is not empty then delete it from storage
            if (!empty($template->media_file)) {
                // Storage::delete($template->media_file);

                unlink(public_path($template->media_file));
            }
            $template->delete();

            return redirect()->route('templates.index')->with('success', 'Template deleted successfully!');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    //=========================================================================================//
    //=========================================Custom Methods==================================//
    /**
     * get templates acording to template type
     */
    public function getTemplates(Request $request)
    {
        try {
            $template = Template::query();

            if ($request->has('search')) {
                $searchTerm = $request->search;
                $template->where('name', 'like', '%' . $searchTerm . '%');
            } elseif ($request->has('type')) {
                $type = $request->type;
                $template->where('type', $type);
            } else {
                $template->orderBy('id', 'desc');
            }

            $templates = $template->get();

            return response()->json([
                'success' => true,
                'templates' => $templates,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
            ]);
        }
    }

    /**
     * get templates message acording to template id
     */
    public function getTemplateMessage(Request $request)
    {
        try {
            $message = Template::findOrFail($request->id)->message;

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
            ]);
        }
    }
}
