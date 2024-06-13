<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\Comp;
use App\Models\Dompet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CapitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['destroy']);
        $this->middleware('active');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $data = Capital::query();
            if ($user->role == 'user') {
                $data->where('user_id', $user->id);
            }
            $result = $data->with('dompet', 'user');
            return DataTables::of($result)->toJson();
        }
        return view('capital.index');
    }
}
