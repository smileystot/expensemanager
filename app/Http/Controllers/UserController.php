<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
class UserController extends Controller
{
    public function insert(Request $request){
        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->role_id = $request->get('role_id');
        $user->password = Hash::make(1);
        $user->save();
    }

    public function Update(Request $request){
        $user = User::find($request->get('id'));
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->role_id = $request->get('role_id');
        $user->save();
    }

    public function Delete(Request $request){
        User::find($request->get('id'))->delete();
    }
}
