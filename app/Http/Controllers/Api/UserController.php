<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('active');
    }

    public function paginate(Request $request)
    {
        $limit = 10;
        if ($request->filled('limit') && is_numeric($request->limit) && $request->limit > 0) {
            $limit = $request->limit;
        }
        $data = User::filter($request->only(['name', 'email']))->paginate($limit)->withQueryString();
        return UserResource::collection($data);
    }

    public function index()
    {
        $data = User::query();
        return DataTables::eloquent($data)->setTransformer(function ($item) {
            return UserResource::make($item)->resolve();
        })->toJson();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:50|min:3',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|numeric|digits_between:10,15',
            'password'  => 'required|min:5',
            'role'      => 'required|in:admin,user',
            'status'    => 'required|in:active,nonactive',
        ]);
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'status'    => $request->status,
        ]);
        return response()->json(['message' => 'Success insert data!', 'data' => new UserResource($user)]);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'      => 'required|max:50|min:3',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'phone'     => 'required|numeric|digits_between:10,15',
            'password'  => 'nullable|min:5',
            'role'      => 'required|in:admin,user',
            'status'    => 'required|in:active,nonactive',
        ]);
        $param = [
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'role'      => $request->role,
            'status'    => $request->status,
        ];

        if ($request->filled('password')) {
            $param['password'] = Hash::make($request->password);
        }
        $user->update($param);
        return response()->json(['message' => 'Success update data!', 'data' => new UserResource($user)]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status' => true, 'message' => 'Success delete data!', 'data' => new UserResource($user)]);
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'    => 'required|array|min:1',
            'id.*'  => 'integer|exists:users,id',
        ]);
        $deleted = 0;
        foreach ($request->id as $id) {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                $deleted++;
            }
        }
        $data = ['message' => 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted), 'data' => ''];
        return response()->json($data);
    }
}
