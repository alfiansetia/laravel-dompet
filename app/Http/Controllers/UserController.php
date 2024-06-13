<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->except(['profile', 'profileUpdate', 'passwordUpdate']);
        $this->middleware('active')->except(['profile']);
        $this->model = User::class;
        $this->filter = ['name'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('user.index');
    }


    public function profile()
    {
        return view('user.profile');
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
        if ($user) {
            return redirect()->route('user.profile')->with(['success' => 'Success update data!']);
        } else {
            return redirect()->route('user.profile')->with(['errorr' => 'Failed update data!']);
        }
    }


    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'password'          => ['required', Password::min(5)->numbers()],
            'confirm_password'  => ['required', 'same:password'],
        ]);
        $user = auth()->user()->update([
            'password'   => Hash::make($request->password),
        ]);
        if ($user) {
            return redirect()->route('user.profile')->with(['success' => 'Success Change Password!']);
        } else {
            return redirect()->route('user.profile')->with(['errorr' => 'Failed Change Password!']);
        }
    }
}
