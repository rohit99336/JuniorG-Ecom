<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function messageReply()
    {
        return view('ecom.admin.emailTemp.msgReply');
    }
}
