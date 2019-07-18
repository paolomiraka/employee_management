<?php

namespace App\Http\Controllers;

use App\User;
use App\Department;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function showAllUsers()
    {

        $users = User::all();
        return view('users.table', compact('users'));
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        return view('users.edit', compact(['user', 'departments']));
    }

    public function edit_profile(User $user)
    {
        $user = User::findOrFail(auth()->id());
        //dd($user);
        return view('users.edit_profile', compact('user'));
    }

    public function update_info($user_id)
    {
        //dd($user_id);
        $user = User::where('id', $user_id)->get()[0];
        $attributes = request()->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        $user->save();

        return redirect('/home');
    }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'department' => 'required'
        ]);

        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        $user->id_dep = $attributes['department'];
        $user->save();

        return redirect('/users/showall');
    }

    public function destroy($user)
    {
        $user = User::find($user);
        $user->delete();
        return redirect('/users/showall');
    }
}
