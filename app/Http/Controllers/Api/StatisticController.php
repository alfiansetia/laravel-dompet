<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Capital;
use App\Models\Dompet;

class StatisticController extends Controller
{
    public function get()
    {
        $data['total_profit'] = Dompet::selectRaw('SUM(saldo) - (SELECT SUM(amount) FROM capitals WHERE status = "success") as profit')->value('profit') ?? 0;
        $data['list_dompet'] = Dompet::orderBy('saldo', 'desc')->take(3)->get();
        $data['total_modal'] = Capital::where('status', 'success')->sum('amount');
        return response()->json($data);
    }
}
