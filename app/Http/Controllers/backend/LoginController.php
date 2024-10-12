<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //show login page
    public function loginPage(){
        return view('backend.login');
    }

    //admin user login process
    public function loged_in(Request $request){
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return response()->json([
                'status' =>true,
                'message' =>"Login Successfull"
            ]);
        } else {
            return response()->json([
                'status' =>false,
                'message' =>"Enter Your Valid Email Or Password"
            ]);
        }
        
    }

    //admin logout
    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
