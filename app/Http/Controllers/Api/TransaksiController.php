<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransaksiResource;
use App\Models\Dompet;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['destroy']);
        $this->middleware('active');
    }

    public function paginate(Request $request)
    {
        $limit = 10;
        if ($request->filled('limit') && is_numeric($request->limit) && $request->limit > 0) {
            $limit = $request->limit;
        }
        $data = Transaksi::filter($request->only(['number', 'user_id', 'from_id', 'to_id', 'status']))->with('user', 'from', 'to')->paginate($limit)->withQueryString();
        return TransaksiResource::collection($data);
    }

    public function index()
    {
        $user = auth()->user();
        $data = Transaksi::query()->with('user', 'from', 'to');
        if ($user->role == 'user') {
            $data->where('user_id', $user->id);
        }
        return DataTables::eloquent($data)->setTransformer(function ($item) {
            return TransaksiResource::make($item)->resolve();
        })->toJson();
    }

    public function show(Transaksi $transaksi)
    {
        $data = $transaksi->load('from', 'to', 'user');
        return new TransaksiResource($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|integer|exists:dompets,id',
            'to'        => 'required|integer|exists:dompets,id|different:from',
            'amount'    => 'required|integer|gt:0|lte:' . Dompet::find($request->from)->saldo,
            'cost'      => 'required|integer|gte:0|lt:' . $request->amount,
            'sell'      => 'required|integer|gte:' . $request->amount,
            'desc'      => 'nullable|max:100',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
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
            $img = null;
            if ($files = $request->file('image')) {
                $destinationPath = public_path('/images/transaksi/');
                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 755, true);
                }
                $img = 'transaksi_' . $number . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $img);
            }
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
                'image'     => $img,
            ]);
            $transaksi->from->update(['saldo' => $transaksi->from->saldo - ($transaksi->amount + $transaksi->cost)]);
            $transaksi->to->update(['saldo' => $transaksi->to->saldo + $transaksi->amount + $transaksi->revenue]);
            DB::commit();
            return response()->json(['message' => 'Transaksi Success!', 'data' => new TransaksiResource($transaksi)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message'   => 'Transaksi Gagal! : ' . $e->getMessage(),
                'data'      => new TransaksiResource($transaksi),
            ], 500);
        }
    }


    public function update(Request $request, Transaksi $transaksi)
    {
        $this->validate($request, [
            'desc'  => 'nullable|max:200',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);
        $img = $transaksi->getRawOriginal('image');
        if ($files = $request->file('image')) {
            $destinationPath = public_path('/images/transaksi/');
            if (!empty($img) && file_exists($destinationPath . $img)) {
                File::delete($destinationPath . $img);
            }
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $img = 'transaksi_' . $transaksi->number . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }
        $transaksi->update([
            'desc'      => $request->desc,
            'image'     => $img,
        ]);
        return response()->json(['message' => 'Success update data!', 'data' => new TransaksiResource($transaksi)]);
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi = $transaksi->load(['user', 'from', 'to']);
        if ($transaksi->status == 'cancel') {
            return $this->handle_unauthorize('Transaksi already cancel!');
        }
        if ($transaksi->to->saldo < ($transaksi->amount + $transaksi->cost - $transaksi->revenue)) {
            return $this->handle_unauthorize('Saldo untuk pembatalan tidak cukup!');
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
            return response()->json(['message' => 'Transaksi has been canceled!', 'data' => new TransaksiResource($transaksi)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message'   => 'Transaksi Gagal! : ' . $e->getMessage(),
                'data'      => new TransaksiResource($transaksi),
            ], 500);
        }
    }
}
