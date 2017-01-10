<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Dashboard on the admin screen
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Account settings page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function account(Request $request)
    {
        $user = $request->user();
        return view('admin.account', compact('user'));
    }

    /**
     * Update account settings
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAccount(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'password' => 'min:6|confirmed',
        ]);
        $user = $request->user();
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

}

