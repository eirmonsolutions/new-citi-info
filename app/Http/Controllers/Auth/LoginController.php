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

        $remember    = $request->boolean('remember');
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ Blocked user check
            if (!empty($user->is_blocked)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->ajax()) {
                    return response()->json([
                        'ok'      => false,
                        'message' => 'Your account is blocked.'
                    ], 403);
                }

                return back()
                    ->withErrors(['email' => 'Your account is blocked.'])
                    ->onlyInput('email');
            }

            // ✅ Role based redirect
            $role = $user->role ?? 'user';

            if ($role === 'superadmin') {
                $redirectTo = route('superadmin.dashboard');
            } elseif ($role === 'admin') {
                $redirectTo = route('admin.dashboard');
            } else {
                // user / lister / any other role
                $redirectTo = route('user.dashboard');
            }

            // ✅ If user was trying to access a protected page first
            // (works when using middleware auth)
            $intended = redirect()->intended($redirectTo)->getTargetUrl();
            $redirectTo = $intended ?: $redirectTo;

            if ($request->ajax()) {
                return response()->json(['ok' => true, 'redirect_to' => $redirectTo]);
            }

            return redirect()->to($redirectTo);
        }

        if ($request->ajax()) {
            return response()->json(['ok' => false, 'message' => 'Invalid email or password.'], 401);
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password'])
            ->onlyInput('email');
    }
}
