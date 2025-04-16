<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek jika pengguna tidak login
        if (!Auth::check()) {
            abort(404);  // Tampilkan halaman 404
        }

        // Cek jika pengguna memiliki role_as == 1 (admin)
        if (Auth::user()->role_as != 1) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
