<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransaksiResource;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $limit = 10;
        if ($request->filled('limit') && is_numeric($request->limit) && $request->limit > 0) {
            $limit = $request->limit;
        }
        $data = Transaksi::with('user', 'from', 'to')->paginate($limit)->withQueryString();
        return TransaksiResource::collection($data);
    }

    public function show(Transaksi $transaksi)
    {
        $data = $transaksi->load('from', 'to', 'user');
        return new TransaksiResource($data);
    }

}
