<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Rules\ReCaptcha;
// use Illuminate\Http\RedirectResponse;

class ContactReqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Messages';
            $subTitle = 'List of Messages';
            $messages = ContactRequest::all();
            $counter = 1;

            if (request()->ajax()) {
                $messages = ContactRequest::with('replied_by');
                return DataTables::of($messages)
                    ->addColumn('sr_no', function () use (&$counter) {
                        return $counter++;
                    })
                    ->addColumn('action', function ($message) {
                        return  '<a href="' . route('ecomadmin.contact-request.show', $message->id) . '"  class="btn btn-primary" title="Show"><i class="bx bx-show "></i></a>' . '&nbsp;&nbsp;<button class="btn btn-danger delete" id="' . $message->id . '" data-id="' . $message->id . '" title="Delete"><i class="bx bx-trash-alt "></i></button>';
                    })

                    ->addColumn('replied_by', function ($message) {
                        return $message->replied_by->name ?? "No reply";
                    })

                    // ->editColumn('status', function ($message) {
                    //     return $message->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                    // })
                    ->rawColumns(['action', 'sr_no', 'replied_by'])
                    ->make(true);
            }
            return view('ecom.admin.customerMessages.index', compact('messages', 'title', 'subTitle'));
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
                'message' => 'required',
                'g-recaptcha-response' => ['required', new ReCaptcha],
            ]);

            if ($validator->fails()) {
                // Log::info($validator->errors());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $contact = new ContactRequest();
            $contact->name = $request->name;
            $contact->phone = $request->phone;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();

            if ($contact) {
                return redirect()->back()->with('success', 'Your message send successfully!');
            }
            return redirect()->back()->with('error', 'message creation failed');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactRequest $contactRequest)
    {
        try {
            $title = 'Messages';
            $subTitle = 'Show Message';
            $message = $contactRequest;
            return view('ecom.admin.customerMessages.show', compact('message', 'title', 'subTitle'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactRequest $contactRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactRequest $contactRequest)
    {
        try {
            $validator = Validator::make($request->all(), [
                'reply_message' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $contactRequest->reply = $request->reply_message;
            $contactRequest->replied_by = auth()->guard('ecomadmin')->user()->id;
            $contactRequest->save();

            // Log::info($contactRequest);


            if ($contactRequest) {
                $token = Str::random(60);
                $data = [
                    'token' => $token,
                    'name' => $contactRequest->name,
                    'email' => $contactRequest->email,
                    'reply' => $contactRequest->reply,
                ];

                Log::info($contactRequest);
                Log::info(getenv('MAIL_FROM_ADDRESS'));

                Mail::send('ecom.admin.emailTemp.msgReply', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'], $data['name'])
                        ->subject('Message Reply');
                    // $message->from(' ', ' ');
                    $message->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
                });

                // Mail::send('ecom.admin.emailTemp.msgReply', ['data' => $data], function ($message) use ($data) {
                //     $message->to($data['email'], $data['name'])->subject('Message Reply');
                //     // $message->from(' ', ' ');
                // });



                // $data = [
                //     'name' => $EcomAdmin->name,
                //     'email' => $EcomAdmin->email,
                //     'token' => $token,
                // ];

                // Mail::send('web.auth.emails.forgot-password', ['data' => $data], function ($message) use ($data) {
                //     $message->to($data['email'], $data['name'])->subject('Reset Password');
                //     // $message->from(' ', ' ');
                // });



                return redirect()->back()->with('success', 'Message replied successfully!');

                // return response()->json([
                //     'success' => true,
                //     'message' => 'Message replied successfully!'
                // ]);

            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());

            // return response()->json([
            //     'success' => false,
            //     'message' => 'Message replied failed'
            // ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactRequest $contactRequest)
    {
        try {
            // $offer = ContactRequest::find($id);
            if ($contactRequest) {
                $contactRequest->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Requested message deleted successfully'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Requested message deleted failed'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }
}
