<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcomMaster;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EcomWebMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Web Master';
            $subTitle = 'Setting';
            $master = EcomMaster::first();
            return view('ecom.admin.web.index', compact('master', 'title', 'subTitle'));
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
            $validator = Validator::make(
                $request->all(),
                [
                    'logo' => 'required',
                    'title' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'whatsapp' => 'required',
                    'facebook' => 'nullable',
                    'instagram' => 'nullable',
                    'youtube' => 'nullable',
                    'twitter' => 'nullable',
                    'address' => 'required',
                    'map_link' => 'required',
                    'meta_description' => 'nullable',
                    'meta_keywords' => 'nullable',
                    'about' => 'nullable',
                ]
            );

            if ($validator->fails()) {
                if (Request()->ajax()) {
                    return response()->json(['error' => $validator->errors()->all()]);
                } else {
                    return back()->withErrors($validator->errors())->withInput();
                }
            }

            if (EcomMaster::where('id', 1)->exists()) {
                $salon = EcomMaster::find(1);
            } else {
                $salon = new EcomMaster();
            }

            $salon->id = 1;
            $salon->logo = $request->logo;
            $salon->title = $request->title;
            $salon->email = $request->email;
            $salon->phone = $request->phone;
            $salon->whatsapp = $request->whatsapp;
            $salon->facebook = $request->facebook;
            $salon->instagram = $request->instagram;
            $salon->youtube = $request->youtube;
            $salon->twitter = $request->twitter;
            $salon->address = $request->address;
            $salon->map_link = $request->map_link;
            $salon->meta_description = $request->meta_description;
            $salon->meta_keywords = $request->meta_keywords;
            $salon->about = $request->about;
            // $salon->start_time = $request->start_time;
            // $salon->close_time = $request->close_time;
            $salon->shipping_charge = $request->shipping_charge;
            $salon->free_shipping_amount = $request->free_shipping_amount;
            $salon->return_days = $request->return_days;
            $salon->save();

            if (Request()->ajax()) {
                return response()->json(['success' => 'Web props updated successfully']);
            } else {
                return redirect()->back()->with('success', 'Web props updated successfully');
            }
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
