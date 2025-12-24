<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;

class SuperadminUserController extends Controller
{
    public function index()
    {
        $users = User::where('email', '!=', 'superadmin15896@gmail.com')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('superadmin.user.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        return back()->with(
            'success',
            $user->is_blocked ? 'User blocked successfully!' : 'User activated successfully!'
        );
    }

    public function destroy(User $user)
    {
        $user->delete(); // hard delete
        return back()->with('success', 'User deleted successfully!');
    }
}
