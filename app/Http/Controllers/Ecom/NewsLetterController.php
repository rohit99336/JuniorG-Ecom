<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsLetter;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Rules\ReCaptcha;

class NewsLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Newsletter';
            $subTitle = 'List of newsletter';
            $newsletters = NewsLetter::all();
            $counter = 1;

            if (request()->ajax()) {
                $newsletters = NewsLetter::select('*');
                return DataTables::of($newsletters)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($offer) {
                        return   '<button class="btn btn-danger delete" id="' . $offer->id . '" data-id="' . $offer->id . '"><i class="bx bx-trash-alt "></i></button>';
                    })
                    ->addColumn('subscribed_at', function ($order) {
                        return date('d-m-Y', strtotime($order->subscribed_at));
                    })
                    ->addColumn('subscribed_time', function ($order) {
                        return date('h:i A', strtotime($order->subscribed_at));
                    })
                    ->rawColumns(['action', 'subscribed_at', 'subscribed_time'])
                    ->make(true);
            }
            return view('ecom.admin.newsLatters.index', compact('newsletters', 'title', 'subTitle'));
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
                'email' => 'required|email|unique:news_letters,email',
                'g-recaptcha-response' => ['required', new ReCaptcha],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $newsLetter = new NewsLetter();
            $newsLetter->email = $request->email;
            $newsLetter->is_subscribed = true;
            // $newsLetter->token = md5(uniqid(rand(), true));
            $newsLetter->subscribed_at = now();
            $newsLetter->ip_address = $request->ip();
            $newsLetter->user_agent = $request->header('User-Agent');
            // $newsLetter->country = $request->country;
            // $newsLetter->city = $request->city;
            // $newsLetter->region = $request->region;
            // $newsLetter->zip = $request->zip;
            // $newsLetter->latitude = $request->latitude;
            // $newsLetter->longitude = $request->longitude;
            // $newsLetter->timezone = $request->timezone;
            // $newsLetter->currency = $request->currency;
            $newsLetter->save();

            if ($newsLetter) {
                return redirect()->back()->with('success', 'Newsletter subscribed successfully')->with('targetDivId', 'nesletter');
            }
            return redirect()->back()->with('error', 'NewsLetter subscription failed');
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
        try {
            $ecomAdmin = auth('ecomadmin')->user();
            $order = NewsLetter::find($id);
            $order->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Email subscribe removed successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.',
            ]);
        }
    }
}
