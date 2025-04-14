<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah user sudah login dan memiliki role_as == 1 (admin)
        if (Auth::check() && Auth::user()->role_as == 1) {
            return $next($request);
        }

        // Redirect jika bukan admin
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}