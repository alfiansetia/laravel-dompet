<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use App\Models\Comp;
use App\Models\Dompet;
use App\Models\Expenditure;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $comp;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->comp = Comp::first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with(['comp' => $this->comp, 'title' => 'Dashboard']);;
    }


    public function getData()
    {
        $data = Dompet::orderBy('saldo', 'desc')->paginate(5);
        return response()->json(['status' => true, 'message' => '', 'data' => $data]);
    }

    public function getStat()
    {
        $data['total'] = Dompet::sum('saldo');
        $data['revenue'] = Transaksi::where('status', 'success')->sum('revenue');
        $data['cost'] = Transaksi::where('status', 'success')->sum('cost');
        $data['capital'] = Capital::where('status', 'success')->sum('amount');
        $data['expenditure'] = Expenditure::where('status', 'success')->sum('amount');
        $data['profit'] = $data['total'] - ($data['capital'] - $data['expenditure']);
        return response()->json(['status' => true, 'message' => '', 'data' => $data]);
    }
}
