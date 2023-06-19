<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Dompet;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExpenditureController extends Controller
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
            $data = Expenditure::with('dompet', 'user')->get();
            return DataTables::of($data)->toJson();
        }
        return view('expenditure.index')->with(['comp' => $this->comp, 'title' => 'Data Expenditure']);
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
            'amount' => 'required|integer|gt:0|lte:' . Dompet::find($request->dompet)->saldo,
            'desc'   => 'nullable|max:100',
        ], [
            'amount.lte' => 'Saldo tujuan tidak cukup!'
        ]);

        DB::beginTransaction();
        try {
            $expenditure = Expenditure::create([
                'user_id'   => auth()->user()->id,
                'date'      => date('Y-m-d H:i:s'),
                'dompet_id' => $request->dompet,
                'amount'    => $request->amount,
                'status'    => 'success',
                'desc'      => $request->desc,
            ]);
            $expenditure->dompet->update([
                'saldo' => $expenditure->dompet->saldo - $expenditure->amount
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Expenditure $expenditure)
    {
        if (!$expenditure) {
            abort(404);
        }
        $expenditure->load('user', 'dompet');
        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => '', 'data' => $expenditure]);
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenditure $expenditure)
    {
        if (!$expenditure) {
            abort(404);
        }
        $this->validate($request, [
            'desc' => 'nullable|max:100'
        ]);
        $expenditure = $expenditure->update([
            'desc' => $request->desc,
        ]);
        if ($expenditure) {
            return response()->json(['status' => true, 'message' => 'Success update data!', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed update data!', 'data' => '']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenditure $expenditure)
    {
        if (!$expenditure) {
            abort(404);
        }
        if ($expenditure->status == 'cancel') {
            return response()->json(['status' => false, 'message' => 'Transaksi already cancel!', 'data' => '']);
        }
        DB::beginTransaction();
        try {
            $expenditure->dompet->update([
                'saldo' => $expenditure->dompet->saldo + $expenditure->amount,
            ]);

            $expenditure->update([
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
