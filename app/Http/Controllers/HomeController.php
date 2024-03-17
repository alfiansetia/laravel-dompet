<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\Comp;
use App\Models\Dompet;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function getData()
    {
        $user = auth()->user();
        $u_dompet = $user->dompets();
        $d_id = $u_dompet->pluck('id');
        if ($user->role == 'user') {
            $saldo = $u_dompet->sum('saldo');
            $modal = Capital::whereIn('dompet_id', $d_id)->where('status', 'success')->sum('amount');
            $data['saldo'] = $saldo;
            $data['modal'] = $modal;
            $data['profit'] = $saldo - $modal;
            $data['dompet'] = $u_dompet->orderBy('saldo', 'desc')->paginate(5);
        } else {
            $data['profit'] = Dompet::selectRaw('SUM(saldo) - (SELECT SUM(amount) FROM capitals WHERE status = "success") as profit')->value('profit') ?? 0;
            $data['dompet'] = Dompet::orderBy('saldo', 'desc')->paginate(5);
            $data['modal'] = Capital::where('status', 'success')->sum('amount');
        }
        return response()->json(['status' => true, 'message' => '', 'data' => $data]);
    }

    public function getChart()
    {
        $user = auth()->user();
        $startDate = Carbon::parse(request()->input('start_date', Carbon::now()->startOfMonth()));
        $endDate = Carbon::parse(request()->input('end_date', Carbon::now()->endOfMonth()));
        $query = Transaksi::select(DB::raw('DATE(date) as transaction_date, SUM(revenue - cost) as total_profit'))
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'success');
        if ($user->role == 'user') {
            $query->where('user_id', $user->id);
        }
        $transactions = $query->groupBy('transaction_date')->get();
        $data = [];
        $labels = [];
        foreach ($transactions as $transaction) {
            $data[] = $transaction->total_profit;
            $labels[] = $transaction->transaction_date;
        }
        return response()->json([
            'data'      => $data,
            'labels'    => $labels,
        ]);
    }
}
