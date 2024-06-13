<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('active')->only(['update']);
    }

    public function index()
    {
        $user = auth()->user();
        return new UserResource($user);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required|min:3|max:50',
            'email'  => 'required|email|unique:users,email,' . auth()->user()->id,
            'phone'  => 'required|numeric|digits_between:10,15',
            'avatar' => 'required|in:boy1.png,boy2.png,girl1.png,girl2.png',
        ]);
        $user = auth()->user();
        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'avatar' => $request->avatar,
        ]);
        return response()->json([
            'message'   => 'Success Update Profile',
            'data'      => new UserResource($user),
        ]);
    }
}
