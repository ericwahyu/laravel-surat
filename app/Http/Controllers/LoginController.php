<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index(){
        return view('login');
    }

    public function proses(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $kredensil = $request->only('email','password');

        if (Auth::attempt($kredensil)) {

            return redirect()->route('index.template');
        }

        return redirect()->route('login')
                            ->withInput()
                            ->withErrors(['login_gagal' => 'These credentials do not match our records.']);
    }

    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return Redirect()->route('login');
    }
}
