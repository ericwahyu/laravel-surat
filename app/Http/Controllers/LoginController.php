<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index(){
        return view('login');
    }

    public function store(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $kredensil = $request->only('email','password');

        if(Auth::attempt($kredensil)) {
            return redirect()->route('index.jenis')->with('success', 'login berhasil !!');
        }

        return redirect()->route('index.login')->with('error','These credentials do not match our records.');

    }

    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return Redirect()->route('index.login');
    }
}
