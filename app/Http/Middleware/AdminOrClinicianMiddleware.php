<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOrClinicianMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->user_type == 2 || Auth::user()->user_type == 3)) {
            return $next($request);
        }
        
        return redirect('/');
    }
}
