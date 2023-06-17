<?php

namespace App\Http\Controllers;

use App\Models\Comp;
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
}
