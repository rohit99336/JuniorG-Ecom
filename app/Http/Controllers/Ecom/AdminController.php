<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcomAdmin;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $title = 'Advertisements';
            $subTitle = 'List of Advertisements';
            $advertisements = EcomAdmin::all();
            $counter = 1;

            if (request()->ajax()) {
                $advertisements = EcomAdmin::query();
                return Datatables::of($advertisements)
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
            return view('ecom.admin.admins.index', compact('advertisements', 'title', 'subTitle'));
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
        try{
            $title = 'Advertisements';
            $subTitle = 'List of Advertisements';
            return view('ecom.admin.admins.create', compact('title', 'subTitle'));

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
