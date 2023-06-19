<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\Comp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CapitalController extends Controller
{
    private $comp;

    public function __construct()
    {
        $this->middleware('admin')->only(['destroy']);
        $this->middleware('active');
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
            $data = Capital::with('dompet', 'user')->get();
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
        DB::beginTransaction();
        try {
            $capital = Capital::create([
                'user_id'   => auth()->user()->id,
                'date'      => date('Y-m-d H:i:s'),
                'dompet_id' => $request->dompet,
                'amount'    => $request->amount,
                'status'    => 'success',
                'desc'      => $request->desc,
            ]);
            $capital->dompet->update([
                'saldo' => $capital->dompet->saldo + $capital->amount
            ]);

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

    function update(Request $request, Capital $capital)
    {
        if (!$capital) {
            abort(404);
        }
        $this->validate($request, [
            'desc' => 'nullable|max:100'
        ]);
        $capital = $capital->update([
            'desc' => $request->desc,
        ]);
        if ($capital) {
            return response()->json(['status' => true, 'message' => 'Success update data!', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed update data!', 'data' => '']);
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
        $capital->load('user', 'dompet');
        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => '', 'data' => $capital]);
        }
        abort(404);
    }

    public function destroy(Capital $capital)
    {
        if (!$capital) {
            abort(404);
        }
        if ($capital->status == 'cancel') {
            return response()->json(['status' => false, 'message' => 'Transaksi already cancel!', 'data' => '']);
        }
        if ($capital->dompet->saldo < $capital->amount) {
            return response()->json(['status' => false, 'message' => 'Saldo untuk pembatalan tidak cukup!', 'data' => '']);
        }
        DB::beginTransaction();
        try {
            $capital->dompet->update([
                'saldo' => $capital->dompet->saldo - $capital->amount,
            ]);

            $capital->update([
                'status' => 'cancel'
            ]);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Transaksi has been canceled!', 'data' => '']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status'    => false,
                'message'   => 'Transaksi Gagal',
                'data'      => '',
            ]);
        }
    }
}
