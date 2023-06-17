<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
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
            $data = Transaksi::with('user', 'from', 'to')->get();
            return DataTables::of($data)->toJson();
        }
        return view('transaksi.index')->with(['comp' => $this->comp, 'title' => 'Data Transaksi']);
    }

    public function create()
    {
        return view('transaksi.add')->with(['comp' => $this->comp, 'title' => 'Add Transaksi']);
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
            'dompet'    => 'required|integer|exists:dompets,id',
            'type'      => 'required|in:in,out',
            'amount'    => 'required|gt:0',
            'cost'      => 'required|gte:0',
            'revenue'   => 'required|gte:0',
            'status'    => 'required|in:success,pending,cancel',
            'desc'      => 'nullable|max:100',
        ]);

        $transaksi = Transaksi::create([
            'dompet_id' => $request->dompet,
            'user_id'   => auth()->user()->id,
            'type'      => $request->type,
            'amount'    => $request->amount,
            'cost'      => $request->cost,
            'revenue'   => $request->revenue,
            'status'    => $request->status,
            'desc'      => $request->desc,
        ]);
        if ($transaksi) {
            return response()->json(['status' => true, 'message' => 'Success insert data!', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed insert data!', 'data' => '']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Transaksi $transaksi)
    {
        if (!$transaksi) {
            abort(404);
        }
        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => '', 'data' => $transaksi]);
        }
        abort(404);
    }
}
