<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Department;
use Image;
use Illuminate\Auth\Access\Gate;



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
        return view('users.edit', compact(['user','departments']));
    }

    public function edit_profile(User $user)
    {
        // if (Gate::allows('edit_profile')) {
             //     dd("kjkkj");
        
        $user = User::findOrFail(auth()->id());
         
        return view('users.edit_profile', compact('user'));
    }

    public function update_info(User $user)
    {
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