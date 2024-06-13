<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DompetResource;
use App\Models\Dompet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        $data = Dompet::query()->filter($request->only(['name', 'user_id']));
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
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);
        $name = $request->name;
        $img = null;
        if ($files = $request->file('image')) {
            $destinationPath = public_path('/images/dompet/');
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $img = 'dompet_' . $name . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }

        $dompet = Dompet::create([
            'name'          => $name,
            'type'          => $request->type,
            'acc_name'      => $request->acc_name,
            'acc_number'    => $request->acc_number,
            'user_id'       => $request->user,
            'image'         => $img,
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
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);
        $name = $request->name;
        $img = $dompet->getRawOriginal('image');
        if ($files = $request->file('image')) {
            $destinationPath = public_path('/images/dompet/');
            if (!empty($img) && file_exists($destinationPath . $img)) {
                File::delete($destinationPath . $img);
            }
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 755, true);
            }
            $img = 'dompet_' . $name . '_' . date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }
        $dompet->update([
            'name'          => $name,
            'type'          => $request->type,
            'acc_name'      => $request->acc_name,
            'acc_number'    => $request->acc_number,
            'user_id'       => $request->user,
            'image'         => $img,
        ]);
        return response()->json(['status' => true, 'message' => 'Success update data!', 'data' => new DompetResource($dompet)]);
    }

    public function destroy(Dompet $dompet)
    {
        $img = $dompet->getRawOriginal('image');
        $destinationPath = public_path('/images/dompet/');
        if (!empty($img) && file_exists($destinationPath . $img)) {
            File::delete($destinationPath . $img);
        }
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
                $img = $dompet->getRawOriginal('image');
                $destinationPath = public_path('/images/dompet/');
                if (!empty($img) && file_exists($destinationPath . $img)) {
                    File::delete($destinationPath . $img);
                }
                $dompet->delete();
                $deleted++;
            }
        }
        $data = ['status' => true, 'message' => 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted), 'data' => ''];
        return response()->json($data);
    }
}
