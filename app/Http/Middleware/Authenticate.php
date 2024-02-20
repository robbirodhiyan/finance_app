<?php

namespace App\Http\Middleware;

use App\Models\User;
// use Illuminate\Auth\Middleware\Authenticate as Middleware;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// class Authenticate extends Middleware
class Authenticate
{
  /**
   * Get the path the user should be redirected to when they are not authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return string|null
   */

  // protected function redirectTo($request)
  // {
  //     // dd($request->expectsJson());
  //     $data=User::find(Session::get('auth'));
  //     if(!$data){
  //       return route('auth');
  //     }

  //     // if (!$request->expectsJson()) {
  //     //     return route('auth');
  //     // }
  // }

  public function handle(Request $request, Closure $next)
  {
    // dd(Session::get('auth'));
    if ($log = Session::get('auth')) {
      $data = User::find($log);
      if (!$data) {
        return route('auth');
      }

      Auth::login($data);
      return $next($request);
    } else {
      return redirect()->route('auth');
    }
  }
}
