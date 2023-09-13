<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransaksiResource;
use App\Http\Resources\UserResource;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $limit = 10;
        if ($request->filled('limit') && is_numeric($request->limit) && $request->limit > 0) {
            $limit = $request->limit;
        }
        $data = User::paginate($limit)->withQueryString();
        return UserResource::collection($data);
    }

    public function profile()
    {
        return response()->json(
            [
                'data' => auth()->user()
            ]
        );
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required|min:3|max:50',
            'email'  => 'required|email|unique:users,email,' . auth()->user()->id,
            'phone'  => 'required|numeric|digits_between:10,15',
            'avatar' => 'required|in:boy1.png,boy2.png,girl1.png,girl2.png',
        ]);
        $user = auth()->user()->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'avatar' => $request->avatar,
        ]);
        return response()->json([
            'message' => 'Success Update Profile'
        ]);
    }
}
