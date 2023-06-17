<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Dompet;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DompetController extends Controller
{
    private $comp;

    public function __construct()
    {
        $this->comp = Comp::first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Dompet::get();
            return DataTables::of($data)->toJson();
        }
        return view('dompet.index')->with(['comp' => $this->comp, 'title' => 'Data Dompet']);
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
            'name'          => 'required|max:50|min:3',
            'type'          => 'required|in:cash,ewallet',
            'acc_name'      => 'required|max:50|min:3',
            'acc_number'    => 'required|max:50|min:3',
        ]);

        $dompet = Dompet::create([
            'name'          => $request->name,
            'type'          => $request->type,
            'acc_name'      => $request->acc_name,
            'acc_number'    => $request->acc_number,
        ]);
        if ($dompet) {
            return response()->json(['status' => true, 'message' => 'Success insert data!', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed insert data!', 'data' => '']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dompet  $dompet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Dompet $dompet)
    {
        if (!$dompet) {
            abort(404);
        }
        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => '', 'data' => $dompet]);
        }
        abort(404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dompet  $dompet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dompet $dompet)
    {
        if (!$dompet) {
            abort(404);
        }
        $this->validate($request, [
            'name'          => 'required|max:50|min:3',
            'type'          => 'required|in:cash,ewallet',
            'acc_name'      => 'required|max:50|min:3',
            'acc_number'    => 'required|max:50|min:3',
        ]);

        $dompet = $dompet->update([
            'name'          => $request->name,
            'type'          => $request->type,
            'acc_name'      => $request->acc_name,
            'acc_number'    => $request->acc_number,
        ]);

        if ($dompet) {
            return response()->json(['status' => true, 'message' => 'Success update data!', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed update data!', 'data' => '']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dompet  $dompet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $this->validate($request, [
            'id'    => 'required|array|min:1',
            'id.*'  => 'integer|exists:dompets,id',
        ]);
        $deleted = 0;
        foreach ($request->id as $id) {
            $user = Dompet::findOrFail($id);
            $user->delete();
            if ($user) {
                $deleted++;
            }
        }
        $data = ['status' => true, 'message' => 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted), 'data' => ''];
        return response()->json($data);
    }
}
