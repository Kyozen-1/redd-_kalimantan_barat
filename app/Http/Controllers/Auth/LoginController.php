<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login.index');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'password'=>'required|max:50'
        ]);
        if(Auth::attempt($request->only('email', 'password'), $request->remember)){
            return redirect()->route('cms.dashboard.index');
        }
        return back()->with('failed', 'email atau password');
    }

    public function logout()
    {
        Auth::logout(Auth::user());
        return redirect()->route('login');
    }
}
