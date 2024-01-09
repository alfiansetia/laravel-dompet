<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CompController extends Controller
{
    private $comp;

    public function __construct()
    {
        $this->middleware(['admin', 'active']);
        $this->comp = Comp::first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('comp.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:30',
            'phone'     => 'required|numeric|digits_between:10,15',
            'address'   => 'required|max:100',
        ]);
        $comp = $this->comp->update([
            'name'      => $request->name,
            'telp'      => $request->telp,
            'address'   => $request->address,
        ]);
        if ($comp) {
            return redirect()->route('comp.index')->with('success', 'Success Update Data!');
        } else {
            return redirect()->route('comp.index')->with('error', 'Failed Update Data!');
        }
    }

    public function update(Request $request, Comp $comp)
    {
        if (!$comp) {
            abort(404);
        }
        $this->validate($request, [
            'logo'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'favicon'   => 'required|image|mimes:png,jpg|max:1024',
        ]);
        $logo = $this->comp->getRawOriginal('logo');
        $fav = $this->comp->getRawOriginal('fav');
        $destinationPath = public_path('images/company/');
        if ($files = $request->file('logo')) {
            $logo = 'logo.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $logo);
        }
        if ($files = $request->file('favicon')) {
            $fav = 'favicon.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $fav);
        }
        $comp = $this->comp->update([
            'logo'      => $logo,
            'favicon'   => $fav,
        ]);
        if ($comp) {
            return redirect()->route('comp.index')->with('success', 'Success Update Data!');
        } else {
            return redirect()->route('comp.index')->with('error', 'Failed Update Data!');
        }
    }
}
