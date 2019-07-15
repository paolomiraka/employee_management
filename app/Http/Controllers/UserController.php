<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Image;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('adminMiddleware');
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
        return view('users.edit', compact('user'));
    }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        //$user->password = bcrypt($attributes['password']);

        $user->save();

        return redirect('/home');
    }

    public function destroy($user)
    {

        $user = User::find($user);
        $user->delete();
        return redirect('/users/showall');
    }

    
}