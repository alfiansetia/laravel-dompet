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
        if ($request->ajax()) {
            $data = User::query();
            return DataTables::of($data)->toJson();
        }
        return view('user.index');
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
        if ($user) {
            return response()->json(['status' => true, 'message' => 'Success insert data!', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed insert data!', 'data' => '']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        if (!$user) {
            abort(404);
        }
        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => '', 'data' => $user]);
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!$user) {
            abort(404);
        }
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
        if ($user) {
            return response()->json(['status' => true, 'message' => 'Success update data!', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed update data!', 'data' => '']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id'    => 'required|array|min:1',
            'id.*'  => 'integer|exists:users,id',
        ]);
        $deleted = 0;
        foreach ($request->id as $id) {
            $user = User::findOrFail($id);
            $user->delete();
            if ($user) {
                $deleted++;
            }
        }
        $data = ['status' => true, 'message' => 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted), 'data' => ''];
        return response()->json($data);
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
