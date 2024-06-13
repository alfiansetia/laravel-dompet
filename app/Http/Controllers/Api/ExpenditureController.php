<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenditureResource;
use App\Models\Dompet;
use App\Models\Expenditure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ExpenditureController extends Controller
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
        $data = Expenditure::filter($request->only(['number', 'user_id', 'status']))->with(['user', 'dompet'])->paginate($limit)->withQueryString();
        return ExpenditureResource::collection($data);
    }

    public function index()
    {
        $user = auth()->user();
        $data = Expenditure::query()->with(['user', 'dompet']);
        if ($user->role == 'user') {
            $data->where('user_id', $user->id);
        }
        return DataTables::eloquent($data)->setTransformer(function ($item) {
            return ExpenditureResource::make($item)->resolve();
        })->toJson();
    }

    public function show(Expenditure $expenditure)
    {
        $expenditure->load('user', 'dompet');
        return new ExpenditureResource($expenditure);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'dompet' => 'required|integer|exists:dompets,id',
            'amount' => 'required|integer|gt:0|lte:' . Dompet::find($request->dompet)->saldo,
            'desc'   => 'nullable|max:100',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ], [
            'amount.lte' => 'Saldo tujuan tidak cukup!'
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
        $count = Expenditure::whereDate('date', $date_parse)->count() ?? 0;
        $number = 'EXP' . date('ymd', strtotime($date)) . str_pad(($count + 1), 3, 0, STR_PAD_LEFT);
        DB::beginTransaction();
        try {
            $img = null;
            if ($files = $request->file('image')) {
                $destinationPath = public_path('/images/expenditure/');
                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 755, true);
                }
                $img = 'expenditure_' . $number . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $img);
            }
            $expenditure = Expenditure::create([
                'user_id'   => auth()->user()->id,
                'date'      => date('Y-m-d H:i:s'),
                'number'    => $number,
                'dompet_id' => $request->dompet,
                'amount'    => $request->amount,
                'status'    => 'success',
                'desc'      => $request->desc,
                'image'     => $img,
            ]);
            $expenditure->dompet->update([
                'saldo' => $expenditure->dompet->saldo - $expenditure->amount
            ]);
            DB::commit();
            return response()->json(['message' => 'Transaksi Success!', 'data' => new ExpenditureResource($expenditure)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message'   => 'Transaksi Gagal! : ' . $e->getMessage(),
                'data'      => new ExpenditureResource($expenditure),
            ]);
        }
    }

    public function update(Request $request, Expenditure $expenditure)
    {
        $this->validate($request, [
            'desc'  => 'nullable|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);
        $img = $expenditure->getRawOriginal('image');
        if ($files = $request->file('image')) {
            $destinationPath = public_path('/images/expenditure/');
            if (!empty($img) && file_exists($destinationPath . $img)) {
                File::delete($destinationPath . $img);
            }
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $img = 'expenditure_' . $expenditure->number . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }
        $expenditure->update([
            'desc'  => $request->desc,
            'image' => $img,
        ]);
        return response()->json(['message' => 'Success update data!', 'data' => new ExpenditureResource($expenditure)]);
    }

    public function destroy(Expenditure $expenditure)
    {
        if ($expenditure->status == 'cancel') {
            return $this->handle_unauthorize('Transaksi already cancel!');
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
            return response()->json(['message' => 'Transaksi has been canceled!', 'data' => new ExpenditureResource($expenditure)]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message'   => 'Transaksi Gagal! : ' . $e->getMessage(),
                'data'      => new ExpenditureResource($expenditure),
            ]);
        }
    }
}
