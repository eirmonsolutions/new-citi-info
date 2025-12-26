<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $remember = $request->boolean('remember');

        // ✅ only email + password
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // ✅ if your table has is_blocked then check, else ignore
            $user = auth()->user();

            if (isset($user->is_blocked) && $user->is_blocked) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is blocked.'])->onlyInput('email');
            }

            $role = $user->role ?? 'user';

            if ($role === 'superadmin') {
                return redirect()->route('superadmin.dashboard');
            }

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
