<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Link Google ID if not already linked
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                    'avatar' => $user->avatar ?? $googleUser->getAvatar(),
                ]);
            }
        } else {
            // Create new customer account
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'role' => UserRole::Customer,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, remember: true);

        $home = match ($user->role) {
            UserRole::Admin => route('admin.dashboard', absolute: false),
            UserRole::Merchant => route('merchant.dashboard', absolute: false),
            default => route('home', absolute: false),
        };

        return redirect()->intended($home);
    }
}
