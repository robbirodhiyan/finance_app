<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // available languages
        $availableLocales = ['en', 'fr', 'de', 'pt'];

        // Check if locale is set in session and is valid
        if (session()->has('locale') && in_array(session()->get('locale'), $availableLocales)) {
            // Set the Laravel locale
            app()->setLocale(session()->get('locale'));
        }

        return $next($request);
    }
}
