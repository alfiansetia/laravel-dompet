<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function getData(Request $request)
    {
        $this->validate($request, [
            'from'      => 'required|date_format:Y-m-d',
            'to'        => 'required|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'user'      => 'nullable|array',
            'user.*'    => 'nullable|exists:users,id',
        ]);
        $user = auth()->user();
        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to)->addDay();
        $result = Transaksi::query();

        if ($user->role == 'user') {
            $result->where('user_id', $user->id);
        }
        if ($request->filled('user') && count($request->user) > 0 && !empty($request->user[0])) {
            $result->whereIn('user_id', $request->user);
        }
        $result->select(DB::raw('DATE(date) as transaction_date, SUM(revenue - cost) as total_profit'))
            ->whereBetween('date', [$from, $to])
            ->where('status', 'success')
            ->where('revenue', '>', 0)
            ->groupBy('transaction_date');
        $data = $result->get();
        return response()->json(['status' => true, 'data' => $data, 'message' => '']);
    }

    public function getDate(Request $request)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:Y-m-d',
            'user'      => 'nullable|array',
            'user.*'    => 'nullable|exists:users,id',
        ]);
        $user = auth()->user();
        $date = Carbon::parse($request->date);
        $result = Transaksi::query();
        if ($user->role == 'user') {
            $result->where('user_id', $user->id);
        }
        if ($request->filled('user') && count($request->user) > 0 && !empty($request->user[0])) {
            $result->whereIn('user_id', $request->user);
        }
        $result->whereDate('date', $date->format('Y-m-d'));
        $data = $result->with('user')->where('status', 'success')->get();
        return response()->json(['status' => true, 'data' => $data, 'message' => '']);
    }
}
