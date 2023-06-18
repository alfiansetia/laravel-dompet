<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Dompet;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'from'      => 'required|integer|exists:dompets,id',
            'to'        => 'required|integer|exists:dompets,id|different:from',
            'amount'    => 'required|gt:0|lte:' . Dompet::find($request->from)->saldo,
            'cost'      => 'required|gte:0',
            'revenue'   => 'required|gte:0',
            'desc'      => 'nullable|max:100',
        ],  [
            'amount.lte' => 'Saldo Dompet Asal tidak cukup',
        ]);
        DB::beginTransaction();
        try {

            Transaksi::create([
                'date'      => date('Y-m-d H:i:s'),
                'from'      => $request->from,
                'to'        => $request->to,
                'user_id'   => auth()->user()->id,
                'amount'    => $request->amount,
                'cost'      => $request->cost,
                'revenue'   => $request->revenue,
                'status'    => 'success',
                'desc'      => $request->desc,
            ]);
            $tambah  = $request->amount - $request->cost + $request->revenue;
            $kurang  = $request->amount + $request->cost;
            $from = Dompet::find($request->from);
            $to = Dompet::find($request->to);

            $from->update(['saldo' => $from->saldo - $kurang]);
            $to->update(['saldo' => $to->saldo + $tambah]);

            DB::commit();

            return response()->json(['status' => true, 'message' => 'Transaksi Success!', 'data' => '']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status'    => false,
                'message'   => 'Transaksi Gagal',
                'data'      => '',
            ]);
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
