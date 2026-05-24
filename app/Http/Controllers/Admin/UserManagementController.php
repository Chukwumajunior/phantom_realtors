<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->role, fn($q, $r) => $q->where('role', $r))
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%"))
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('merchantProfile');

        return view('admin.users.show', compact('user'));
    }

    public function suspend(User $user)
    {
        $user->update(['status' => UserStatus::Suspended]);

        return back()->with('success', 'User suspended.');
    }

    public function unsuspend(User $user)
    {
        $user->update(['status' => UserStatus::Active]);

        return back()->with('success', 'User unsuspended.');
    }
}
