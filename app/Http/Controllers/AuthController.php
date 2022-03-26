<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function show_login(){
        return view('admin.login');
    }
    public function do_login (Request $request){
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember_me ? true : false;
        if(auth()->attempt(
            ['email'=>$email,'password'=>$password],
            $remember
        )){
            return redirect(route('admin.blogs.index'));
        }else{
            return redirect()->back();
        }

    }
}
