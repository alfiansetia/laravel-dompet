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
        if ($request->ajax()) {
            $user = auth()->user();
            $data = Dompet::query();
            if ($user->role != 'admin') {
                $data->where('user_id', $user->id);
            }
            return DataTables::of($data->with('user'))->toJson();
        }
        return view('dompet.index');
    }
}
