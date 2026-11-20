<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;

use App\Models\Advertisement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Advertisements';
            $subTitle = 'List of Advertisements';
            $advertisements = Advertisement::all();
            $counter = 1;

            if (request()->ajax()) {
                $advertisements = Advertisement::query();
                return DataTables::of($advertisements)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($advertisement) {
                        // return  '<a href="' . route('ecomadmin.advertisement.show', $advertisement->id) . '"  class="btn btn-primary" title="Show"><i class="bx bx-show "></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $advertisement->id . '" data-id="' . $advertisement->id . '" title="Delete"><i class="bx bx-trash-alt "></i></button>';

                        return '<button class="btn btn-primary edit" id="' . $advertisement->id . '"><i class="bx bx-edit-alt "></i></button>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $advertisement->id . '" data-id="' . $advertisement->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->editColumn('image', function ($advertisement) {
                        return '<img src="' . $advertisement->image . '" alt="' . $advertisement->title . '" class="img-thumbnail" width="100px" height="100px">';
                    })
                    ->addColumn('status', function ($advertisement) {
                        return $advertisement->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    })
                    ->rawColumns(['action', 'sr_no', 'status', 'image'])
                    ->make(true);
            }
            return view('ecom.admin.advertisements.index', compact('advertisements', 'title', 'subTitle'));
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
            $title = 'Create Advertisement';
            $subTitle = 'Create new advertisement';
            return view('ecom.admin.advertisements.create', compact('title', 'subTitle'));
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
        // Log::info($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'required',
                'url' => 'nullable|url',
                'position' => 'nullable',
                'media' => 'required',
                'order' => 'nullable',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'type' => 'nullable',
                'description' => 'required',
                'button_text' => 'required',
                'button_url' => 'required|url',
                'for' => 'nullable',
            ]);

            if ($validator->fails()) {
                Log::error($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $advertisement = new Advertisement();
            $advertisement->title = $request->title;
            $advertisement->image = $request->image;
            $advertisement->url = $request->url ?? $request->button_url;
            $advertisement->position = $request->position;
            $advertisement->media = $request->media;
            $advertisement->order = $request->order;
            $advertisement->start_date = $request->start_date;
            $advertisement->end_date = $request->end_date;
            $advertisement->type = $request->type;
            $advertisement->description = $request->description;
            $advertisement->button_text = $request->button_text;
            $advertisement->button_url = $request->button_url;
            $advertisement->for = $request->for;
            $advertisement->save();

            return redirect()->route('ecomadmin.advertisement.index')->with('success', 'Advertisement created successfully');
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
            $ads = Advertisement::find($id);
            return response()->json([
                'status' => 'success',
                'data' => $ads
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
        // Log::info($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'required',
                'url' => 'nullable|url',
                'position' => 'nullable',
                'media' => 'required',
                'order' => 'nullable',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'type' => 'nullable',
                'description' => 'required',
                'button_text' => 'required',
                'button_url' => 'required|url',
                'for' => 'nullable',
            ]);

            if ($validator->fails()) {
                Log::error($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $advertisement = Advertisement::find($id);
            $advertisement->title = $request->title;
            $advertisement->image = $request->image;
            $advertisement->url = $request->url ?? $request->button_url;
            $advertisement->position = $request->position;
            $advertisement->media = $request->media;
            $advertisement->order = $request->order;
            $advertisement->start_date = $request->start_date;
            $advertisement->end_date = $request->end_date;
            $advertisement->type = $request->type;
            $advertisement->description = $request->description;
            $advertisement->button_text = $request->button_text;
            $advertisement->button_url = $request->button_url;
            $advertisement->for = $request->for;
            $advertisement->save();

            return redirect()->route('ecomadmin.advertisement.index')->with('success', 'Advertisement updated successfully');
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
            $advertisement = Advertisement::find($id);
            if ($advertisement) {
                $advertisement->delete();
                return response()->json(['success' => 'Advertisement deleted successfully']);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
