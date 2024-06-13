<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CapitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('active');
    }

    public function index()
    {
        return view('capital.index');
    }
}
