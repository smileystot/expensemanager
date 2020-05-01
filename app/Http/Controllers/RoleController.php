<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    public function insert(Request $request){
        $role = new Role;
        $role->name = $request->get('name');
        $role->description = $request->get('description');
        $role->save();
    }

    public function Update(Request $request){
        $role = Role::find($request->get('id'));
        $role->name = $request->get('name');
        $role->description = $request->get('description');
        $role->save();
    }

    public function Delete(Request $request){
        Role::find($request->get('id'))->delete();
    }
}
