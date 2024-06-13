<?php

namespace App\Http\Controllers;

use App\Models\Dompet;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
