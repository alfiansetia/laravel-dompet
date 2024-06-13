<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function __construct()
    {
        $this->middleware('active');
    }

    public function index()
    {
        return view('expenditure.index');
    }
}
