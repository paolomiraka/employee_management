<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Department;

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

    public function showAllDepartments()
    {
        $departments = Department::all();
       // dd($departments);
        return view('departments.deptree', compact('departments'));
        
    }

    //tree build

    public function _buildTree(array $elements, $id_parent = 0){
        $branch = array();

        foreach ($elements as $element) {
            if ($element['id_parent'] == $id_parent){
                $children = $this->_buildTree($elements, $element['id']);
                if($children){
                    $element['children'] = $children;
                }

                $sub_array['id'] = $element['id'];
                $sub_array['text'] = $element['text'];
                $sub_array['children'] = $children;

                $state['opened'] = false;
                $state['disabled'] = false;
                $state['selected'] = false;

                $sub_array['state'] = $state;

                $branch[] = $sub_array;
            }
        }

        return $branch;
    }

    public function fill_treeView(){

        $query = Department::all();

        $data = array();

        foreach ($query as $row){
            $sub_array['id'] = $row->id;
            $sub_array['text'] = $row->name;
            $sub_array['children'] = $row->id_parent;
            $data[] = $sub_array;
        }

        $tree = $this->_buildTree($data);
        //dd($tree);
        echo jscon_encode($tree);
    }

    public function fill_parent_department()
    {
        $data = Department::all();

        $res = array();

        foreach($data as $key=>$d){
            $res [] = $d;
        }

    }

    public function add_tree(){
        $attributes = request()->validate([
            'parent_department' => 'required',
            'child_department' => 'required'
        ]);

        $new_dep = new Department();
        $new_dep->name = $attributes['child_department'];
        $new_dep->id_parent = $attributes['parent_department'];
        $new_dep->save();

        //dd($attributes['child_department']);
        $departments = Department::all();
         //dd($departments);
        return view('departments.deptree', compact('departments'));
    }

}
