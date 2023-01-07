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
            'login'    => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL )
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => $request->input('login')
        ]);

        if (Auth::attempt($request->only($login_type, 'password'))) {
            return redirect()->route('dashboard')->with('success', 'Berhasil login !!');
        }

        return redirect()->back()->with('error', 'Gagal login !!');
    }

    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return Redirect()->route('index.login');
    }
}
