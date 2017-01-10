<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('is_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::oldest('created_at')->paginate(20);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_list = trans('user.role');
        $status_list = trans('user.status');
        return view('user.create', compact('role_list', 'status_list'));
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User($request->all());
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->action('UserController@index')->with([
            'message' => trans('user.flash_message.store'),
            'status' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $role_list = trans('user.role');
        $status_list = trans('user.status');

        return view('user.edit', compact('user', 'role_list', 'status_list'));
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

        $this->validate($request, [
            'name' => 'required|max:255',
            'password' => 'min:6|confirmed',
        ]);

        $user->fill($request->all());

        if (request('password')) {
            $user->password = bcrypt(request('password'));
        }

        $user->save();

        return redirect()->back()->with([
            'message' => trans('user.flash_message.update'),
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->action('UserController@index')->with([
            'message' => trans('user.flash_message.delete'),
            'status' => 'success'
        ]);
    }
}
