<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CapitalResource;
use App\Models\Capital;
use App\Models\Dompet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class CapitalController extends Controller
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
        $data = Capital::filter($request->only(['number', 'user_id', 'status']))->with(['user', 'dompet'])->paginate($limit)->withQueryString();
        return CapitalResource::collection($data);
    }

    public function index()
    {
        $user = auth()->user();
        $data = Capital::query()->with(['user', 'dompet']);
        if ($user->role == 'user') {
            $data->where('user_id', $user->id);
        }
        return DataTables::eloquent($data)->setTransformer(function ($item) {
            return CapitalResource::make($item)->resolve();
        })->toJson();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'dompet' => 'required|integer|exists:dompets,id',
            'amount' => 'required|integer|gt:0',
            'desc'   => 'nullable|max:100',
        ]);
        $user = auth()->user();
        if ($user->role == 'user') {
            $dompet = Dompet::find($request->dompet);
            if ($dompet->user_id != $user->id) {
                return $this->handle_unauthorize();
            }
        }
        $date = date('Y-m-d');
        $date_parse = Carbon::parse($date);
        $count = Capital::whereDate('date', $date_parse)->count() ?? 0;
        $number = 'CAP' . date('ymd', strtotime($date)) . str_pad(($count + 1), 3, 0, STR_PAD_LEFT);
        DB::beginTransaction();
        try {
            $img = null;
            if ($files = $request->file('image')) {
                $destinationPath = public_path('/images/capital/');
                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 755, true);
                }
                $img = 'capital_' . $number . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $img);
            }
            $capital = Capital::create([
                'user_id'   => auth()->user()->id,
                'date'      => date('Y-m-d H:i:s'),
                'number'    => $number,
                'dompet_id' => $request->dompet,
                'amount'    => $request->amount,
                'status'    => 'success',
                'desc'      => $request->desc,
                'image'     => $img
            ]);
            $capital->dompet->update([
                'saldo' => $capital->dompet->saldo + $capital->amount
            ]);
            DB::commit();
            return response()->json(['message' => 'Transaksi Success!', 'data' => new CapitalResource($capital)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message'   => 'Transaksi Gagal! : ' . $e->getMessage(),
                'data'      => new CapitalResource($capital),
            ], 500);
        }
    }

    function update(Request $request, Capital $capital)
    {
        $this->validate($request, [
            'desc' => 'nullable|max:100'
        ]);
        $img = $capital->getRawOriginal('image');
        if ($files = $request->file('image')) {
            $destinationPath = public_path('/images/capital/');
            if (!empty($img) && file_exists($destinationPath . $img)) {
                File::delete($destinationPath . $img);
            }
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $img = 'capital_' . $capital->number . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }
        $capital->update([
            'desc'  => $request->desc,
            'image' => $img
        ]);
        return response()->json(['message' => 'Success update data!', 'data' => new CapitalResource($capital)]);
    }

    public function show(Capital $capital)
    {
        $capital->load('user', 'dompet');
        return new CapitalResource($capital);
    }

    public function destroy(Capital $capital)
    {
        if ($capital->status == 'cancel') {
            return $this->handle_unauthorize('Transaksi already cancel!');
        }
        if ($capital->dompet->saldo < $capital->amount) {
            return $this->handle_unauthorize('Saldo untuk pembatalan tidak cukup!');
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
            return response()->json(['message' => 'Transaksi has been canceled!', 'data' => '']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message'   => 'Transaksi Gagal! : ' . $e->getMessage(),
                'data'      => new CapitalResource($capital),
            ], 500);
        }
    }
}
