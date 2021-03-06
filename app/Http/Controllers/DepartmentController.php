<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Department;
use App\User;
use Illuminate\Support\Facades\DB;
use Alert;

class DepartmentController extends Controller
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

    public function update_id_dep($user_id)
    {

        DB::table('users')->where('id', $user_id)->update(['id_dep' => null]);

        return redirect('/departments/tree');
    }


    public function update(User $user)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        $user->save();
        

        return redirect('/home');
    }


    public function show_dep($dep_id)
    {

        $department = Department::where('id', $dep_id)->get()[0];
        $users = User::where('id_dep', $dep_id)->get();

        return view('departments.show_dep', compact(['department', 'users']));
    }

    public function delete()
    {
        $dep_id = request('department');

        $department = Department::find($dep_id);
        //dd($department);
        $users = User::where('id_dep', $dep_id)->get();

        if ($users->isEmpty()) {
            $department->delete();
            alert()->success('Done!', 'Good bye!');
        }
        alert()->error('Department not empty');
        return redirect()->route('tree');
    }

    public function treeView()
    {
        $departments_tree = Department::where('parent_id', 0)->get();
        $departments = Department::all();
        $tree = '<ul id="browser" class="filetree"><li class="tree-view"></li>';
        foreach ($departments_tree as $department_tree) {
            $tree .= '<li class="tree-view "><a href="/departments/show/' . $department_tree->id . '" class="tree-name">' . $department_tree->name . '</a>';
            if (count($department_tree->childs)) {
                $tree .= $this->childView($department_tree);
            }
        }
        $tree .= '<ul>';

        return view('departments.deptree', compact(['tree', 'departments']));
    }
    public function childView($department)
    {
        $html = '<ul>';
        foreach ($department->childs as $arr) {
            if (count($arr->childs)) {
                $html .= '<li class="tree-view closed"><a href="/departments/show/' . $arr->id . '"class="tree-name">' . $arr->name . '</a>';
                $html .= $this->childView($arr);
            } else {
                $html .= '<li class="tree-view"><a href="/departments/show/' . $arr->id . '"class="tree-name">' . $arr->name . '</a>';
                $html .= "</li>";
            }
        }

        $html .= "</ul>";
        return $html;
    }

    public function add_tree()
    {

        $attributes = request()->validate([
            'parent_department' => 'required',
            'child_department' => 'required'
        ]);

        $new_dep = new Department();
        $new_dep->name = $attributes['child_department'];
        $new_dep->parent_id = $attributes['parent_department'];
        $new_dep->save();

        return redirect()->route('tree');
    }

    public function code_view($dep_code)
    {
        $department = Department::where('code', $dep_code)->get()[0];

    }
}
