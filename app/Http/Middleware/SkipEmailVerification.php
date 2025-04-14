<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SkipEmailVerification
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user login dengan kode, lewati verifikasi email
        if ($request->session()->has('login_with_code')) {
            return $next($request);
        }

        // Jika user tidak login dengan kode, gunakan middleware verifikasi email bawaan Laravel
        if (! $request->user() || ! $request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
