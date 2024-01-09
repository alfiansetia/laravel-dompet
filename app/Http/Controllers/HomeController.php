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
        $data['profit'] = Dompet::selectRaw('SUM(saldo) - (SELECT SUM(amount) FROM capitals WHERE status = "success") as profit')->value('profit') ?? 0;
        $data['dompet'] = Dompet::orderBy('saldo', 'desc')->paginate(5);
        $data['modal'] = Capital::where('status', 'success')->sum('amount');
        return response()->json(['status' => true, 'message' => '', 'data' => $data]);
    }

    public function getChart()
    {
        $startDate = Carbon::parse(request()->input('start_date', Carbon::now()->startOfMonth()));
        $endDate = Carbon::parse(request()->input('end_date', Carbon::now()->endOfMonth()));

        $transactions = Transaksi::select(DB::raw('DATE(date) as transaction_date, SUM(revenue - cost) as total_profit'))
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'success')
            ->groupBy('transaction_date')
            ->get();
        $data = [];
        $labels = [];
        foreach ($transactions as $transaction) {
            $data[] = $transaction->total_profit;
            $labels[] = $transaction->transaction_date;
        }
        return response()->json([
            'data' => $data,
            'labels' => $labels,
        ]);
    }
}
