<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        cache()->flush();

        if ($user->role_as == '1') // Admin
        {
            return redirect()->route('admin.dashboard')->with('status', 'Selamat Datang di Dashboard!');
        }
        if ($user->role_as == '2') // Teacher
        {
            return redirect()->route('teacher.dashboard')->with('status', 'Selamat Datang di Dashboard!');
        }
        if ($user->role_as == '0') // User Biasa
        {
            return redirect()->route('user.dashboard')->with('status', 'Selamat Datang di Dashboard!');
        }

        return redirect('/')->with('status', 'Log-in Berhasil!');
    }
}
