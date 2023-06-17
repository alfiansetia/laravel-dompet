<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\Comp;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CapitalController extends Controller
{
    private $comp;

    public function __construct()
    {
        $this->comp = Comp::first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Capital::with('dompet')->get();
            return DataTables::of($data)->toJson();
        }
        return view('capital.index')->with(['comp' => $this->comp, 'title' => 'Data Capital']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'dompet' => 'required|integer|exists:dompets,id',
            'amount' => 'required|integer|gt:0',
            'desc'   => 'nullable|max:100',
        ]);
        $capital = Capital::create([
            'date'      => date('Y-m-d H:i:s'),
            'dompet_id' => $request->dompet,
            'amount'    => $request->amount,
            'desc'      => $request->desc,
        ]);
        if ($capital) {
            return response()->json(['status' => true, 'message' => 'Success insert data!', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed insert data!', 'data' => '']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Capital  $capital
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Capital $capital)
    {
        if (!$capital) {
            abort(404);
        }
        // $data = Capital::with('dompet')->find($capital->id);
        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => '', 'data' => $capital]);
        }
        abort(404);
    }
}
