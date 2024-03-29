<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Dompet;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['destroy']);
        $this->middleware('active');
        $this->model = Transaksi::class;
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
            $data = Transaksi::query();
            if ($user->role == 'user') {
                $data->where('user_id', $user->id);
            }
            $result = $data->with('user', 'from', 'to');
            return DataTables::of($result)->toJson();
        }
        return view('transaksi.index');
    }

    public function create()
    {
        // return view('transaksi.add')->with(['comp' => $this->comp, 'title' => 'Add Transaksi']);
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
            'amount'    => 'required|integer|gt:0|lte:' . Dompet::find($request->from)->saldo,
            'cost'      => 'required|integer|gte:0|lt:' . $request->amount,
            'sell'      => 'required|integer|gte:' . $request->amount,
            'desc'      => 'nullable|max:100',
        ],  [
            'amount.lte' => 'Saldo Dompet Asal tidak cukup',
        ]);

        $user = auth()->user();
        if ($user->role == 'user') {
            $from = Dompet::find($request->from);
            $to = Dompet::find($request->to);
            if ($from->user_id != $user->id && $to->user_id != $user->id) {
                return $this->handle_unauthorize();
            }
        }

        $date = date('Y-m-d');
        $date_parse = Carbon::parse($date);
        $count = Transaksi::whereDate('date', $date_parse)->count() ?? 0;
        $number = 'TRX' . date('ymd', strtotime($date)) . str_pad(($count + 1), 3, 0, STR_PAD_LEFT);
        DB::beginTransaction();
        try {
            $revenue = $request->sell - $request->amount;
            $transaksi = Transaksi::create([
                'date'      => date('Y-m-d H:i:s'),
                'number'    => $number,
                'from_id'   => $request->from,
                'to_id'     => $request->to,
                'user_id'   => auth()->user()->id,
                'amount'    => $request->amount,
                'cost'      => $request->cost,
                'revenue'   => $revenue,
                'status'    => 'success',
                'desc'      => $request->desc,
            ]);
            $transaksi->from->update(['saldo' => $transaksi->from->saldo - ($transaksi->amount + $transaksi->cost)]);
            $transaksi->to->update(['saldo' => $transaksi->to->saldo + $transaksi->amount + $transaksi->revenue]);

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


    public function update(Request $request, Transaksi $transaksi)
    {
        if (!$transaksi) {
            abort(404);
        }
        $this->validate($request, [
            'desc' => 'nullable|max:100'
        ]);
        $transaksi = $transaksi->update([
            'desc' => $request->desc,
        ]);
        if ($transaksi) {
            return response()->json(['status' => true, 'message' => 'Success update data!', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed update data!', 'data' => '']);
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
        $transaksi->load('from', 'to', 'user');
        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => '', 'data' => $transaksi]);
        }
        abort(404);
    }

    public function destroy(Transaksi $transaksi)
    {
        if (!$transaksi) {
            abort(404);
        }
        if ($transaksi->status == 'cancel') {
            return response()->json(['status' => false, 'message' => 'Transaksi already cancel!', 'data' => '']);
        }
        if ($transaksi->to->saldo < ($transaksi->amount + $transaksi->cost - $transaksi->revenue)) {
            return response()->json(['status' => false, 'message' => 'Saldo tujuan untuk pembatalan tidak cukup!', 'data' => '']);
        }
        DB::beginTransaction();
        try {
            $transaksi->from->update([
                'saldo' => $transaksi->from->saldo + $transaksi->amount + $transaksi->cost,
            ]);
            $transaksi->to->update([
                'saldo' => $transaksi->to->saldo - $transaksi->amount - $transaksi->revenue
            ]);

            $transaksi->update([
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
