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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = auth()->user();

            if (isset($user->is_blocked) && $user->is_blocked) {
                Auth::logout();

                if ($request->ajax()) {
                    return response()->json(['ok' => false, 'message' => 'Your account is blocked.'], 403);
                }

                return back()->withErrors(['email' => 'Your account is blocked.'])->onlyInput('email');
            }

            $role = $user->role ?? 'user';

            $redirectTo = route('homepage');
            if ($role === 'superadmin') $redirectTo = route('superadmin.dashboard');
            if ($role === 'admin') $redirectTo = route('admin.dashboard');

            if ($request->ajax()) {
                return response()->json(['ok' => true, 'redirect_to' => $redirectTo]);
            }

            return redirect()->to($redirectTo);
        }

        if ($request->ajax()) {
            return response()->json(['ok' => false, 'message' => 'Invalid email or password.'], 401);
        }

        return back()->withErrors(['email' => 'Invalid email or password'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
