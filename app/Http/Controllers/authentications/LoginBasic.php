<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);
    // dd($request->only('email','password'));
    if (!$token = auth()->attempt($request->only('email', 'password'))) {
      return response()->json([
        'error' => 'Unauthorized',
        'message' => 'Email or Password is incorrect'
      ], 401);
    }


    return response()->json([
      'token' => $token,
      'message' => 'Login Success'
    ], 200);
  }

  public function user(Request $request)
  {
    if (!$request->user()) {
      return response()->json([
        'error' => 'Unauthorized',
        'message' => 'Email or Password is incorrect'
      ], 401);
    }

    Session::put('auth', $request->user()->id);


    return response()->json([
      'user' => auth()->user(),
      'message' => 'User authenticated successfully'
    ], 200);
  }

  public function logout(Request $request)
  {
    Auth::guard('web')->logout();
    // delete session Session::get('auth')
    Session::forget('auth');

    $request->session()->invalidate();

    $request->session()->regenerateToken();
    return redirect()->route('auth');
  }
}
