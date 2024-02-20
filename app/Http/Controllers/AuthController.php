<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

$controller_path = 'App\Http\Controllers';

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('content.authentications.auth-login-basic');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->with('error', 'Invalid credentials');
        }
    }

    public function dashboard()
    {
        return view('content.dashboard.dashboards-analytics');
    }
}
