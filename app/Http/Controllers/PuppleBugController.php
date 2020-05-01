<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JavaScript;
use App\User;
class PuppleBugController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(){
        $auth_id = Auth::User()->id;
        $auth_name = Auth::User()->name;
        $role_id = Auth::User()->role_id;
        $role_name = Auth::User()->role_name;
        JavaScript::put([
            'auth_id' => $auth_id,
            'auth_name' => $auth_name,
            'role_id' => $role_id,
            'role_name' => $role_name
        ]);
        return view('pages.app');
    }

    public function change_password(Request $request){
        $user = User::find($request->get('id'));
        $user->password = Hash::make($request->get('password'));
        $user->save();
    }
}
