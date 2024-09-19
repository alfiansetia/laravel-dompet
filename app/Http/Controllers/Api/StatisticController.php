<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Capital;
use App\Models\Dompet;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function get()
    {
        $data['total_profit'] = Dompet::selectRaw('SUM(saldo) - (SELECT SUM(amount) FROM capitals WHERE status = "success") as profit')->value('profit') ?? 0;
        $data['list_dompet'] = Dompet::orderBy('saldo', 'desc')->take(3)->get();
        $data['total_modal'] = Capital::where('status', 'success')->sum('amount');
        return response()->json($data);
    }

    public function chart_revenue_all()
    {
        $user = auth()->user();
        $query = Transaksi::select(DB::raw('DATE_FORMAT(date, "%Y-%m") as transaction_month, SUM(revenue - cost) as total_profit'))
            ->where('status', 'success');

        if ($user->role == 'user') {
            $query->where('user_id', $user->id);
        }

        $transactions = $query->groupBy('transaction_month')->get();

        $data = [];
        $labels = [];
        foreach ($transactions as $transaction) {
            $data[] = $transaction->total_profit;
            $labels[] = $transaction->transaction_month;
        }
        return response()->json([
            'data'      => $data,
            'labels'    => $labels,
        ]);
    }
}
