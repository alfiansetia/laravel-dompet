<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DompetResource;
use App\Models\Dompet;
use Illuminate\Http\Request;

class DompetController extends Controller
{
    public function index(Request $request)
    {
        $limit = 10;
        if ($request->filled('limit') && is_numeric($request->limit) && $request->limit > 0) {
            $limit = $request->limit;
        }
        $data = Dompet::paginate($limit)->withQueryString();
        return DompetResource::collection($data);
    }

    public function show(Dompet $dompet)
    {
        return new DompetResource($dompet);
    }
}
