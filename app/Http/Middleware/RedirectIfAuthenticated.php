<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Check if user is already authenticated
        if (Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        // Check if there's a logged in session
        $loggedInUserId = Session::get('auth');
        if ($loggedInUserId) {
            $user = User::find($loggedInUserId);
            if ($user) {
                return redirect()->route('dashboard'); // Redirect to the dashboard route
            }
        }

        return $next($request);
    }
}
