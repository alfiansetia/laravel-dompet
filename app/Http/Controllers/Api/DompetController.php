<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DompetResource;
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

    public function index()
    {
        $user = auth()->user();
        $data = Dompet::query()->with('user');
        if ($user->role != 'admin') {
            $data->where('user_id', $user->id);
        }
        return DataTables::eloquent($data)->setTransformer(function ($item) {
            return DompetResource::make($item)->resolve();
        })->toJson();
    }

    public function show(Dompet $dompet)
    {
        return new DompetResource($dompet->load('user'));
    }

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
        return response()->json(['status' => true, 'message' => 'Success insert data!', 'data' => new DompetResource($dompet)]);
    }

    public function update(Request $request, Dompet $dompet)
    {
        $this->validate($request, [
            'name'          => 'required|max:50|min:3',
            'type'          => 'required|in:cash,ewallet',
            'acc_name'      => 'required|max:50|min:3',
            'acc_number'    => 'required|max:50|min:3',
            'user'          => 'required|exists:users,id',
        ]);
        $dompet->update([
            'name'          => $request->name,
            'type'          => $request->type,
            'acc_name'      => $request->acc_name,
            'acc_number'    => $request->acc_number,
            'user_id'       => $request->user,
        ]);
        return response()->json(['status' => true, 'message' => 'Success update data!', 'data' => new DompetResource($dompet)]);
    }

    public function destroy(Dompet $dompet)
    {
        $dompet->delete();
        return response()->json(['status' => true, 'message' => 'Success delete data!', 'data' => new DompetResource($dompet)]);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'    => 'required|array|min:1',
            'id.*'  => 'integer|exists:dompets,id',
        ]);
        $deleted = 0;
        foreach ($request->id as $id) {
            $dompet = Dompet::find($id);
            if ($dompet) {
                $dompet->delete();
                $deleted++;
            }
        }
        $data = ['status' => true, 'message' => 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted), 'data' => ''];
        return response()->json($data);
    }
}
