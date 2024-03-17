<?php

namespace App\Http\Controllers;

use App\Models\Dompet;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DompetController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show', 'paginate']);
        $this->middleware('active');
    }

    public function paginate(Request $request)
    {
        $limit = 10;
        if ($request->filled('limit') && is_numeric($request->limit) && $request->limit > 10) {
            $limit = $request->limit;
        }
        $user = auth()->user();
        $data = Dompet::query();
        if ($user->role != 'admin') {
            $data->where('user_id', $user->id);
        }
        return response()->json($data->paginate($limit));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $data = Dompet::query();
            if ($user->role != 'admin') {
                $data->where('user_id', $user->id);
            }
            return DataTables::of($data->with('user'))->toJson();
        }
        return view('dompet.index');
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
            'user'          => 'required|exists:users,id',
        ]);

        $dompet = Dompet::create([
            'name'          => $request->name,
            'type'          => $request->type,
            'acc_name'      => $request->acc_name,
            'acc_number'    => $request->acc_number,
            'user_id'       => $request->user,
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
            return response()->json(['status' => true, 'message' => '', 'data' => $dompet->load('user')]);
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
            'user'          => 'required|exists:users,id',

        ]);

        $dompet = $dompet->update([
            'name'          => $request->name,
            'type'          => $request->type,
            'acc_name'      => $request->acc_name,
            'acc_number'    => $request->acc_number,
            'user_id'       => $request->user,
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
            $dompet = Dompet::findOrFail($id);
            $dompet->delete();
            if ($dompet) {
                $deleted++;
            }
        }
        $data = ['status' => true, 'message' => 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted), 'data' => ''];
        return response()->json($data);
    }
}
