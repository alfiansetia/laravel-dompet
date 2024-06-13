<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DompetController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('active');
    }

    public function index(Request $request)
    {
        return view('dompet.index');
    }
}
