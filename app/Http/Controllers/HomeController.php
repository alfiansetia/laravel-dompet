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
        $data['profit'] = Dompet::selectRaw('SUM(saldo) - (SELECT SUM(amount) FROM capitals WHERE status = "success") as profit')->value('profit');
        return response()->json(['status' => true, 'message' => '', 'data' => $data]);
    }
}
