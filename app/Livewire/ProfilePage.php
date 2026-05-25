<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class ProfilePage extends Component
{
    use WithFileUploads;

    // Profile fields
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $bio = '';
    public $avatar;
    public ?string $currentAvatar = null;

    // Password fields
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Delete account
    public string $delete_password = '';
    public bool $showDeleteModal = false;

    // Notifications
    public string $profileMessage = '';
    public string $passwordMessage = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->city = $user->city ?? '';
        $this->state = $user->state ?? '';
        $this->bio = $user->bio ?? '';
        $this->currentAvatar = $user->avatar;
    }

    public function updateProfile(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($this->avatar) {
            if ($this->currentAvatar && Storage::disk('public')->exists($this->currentAvatar)) {
                Storage::disk('public')->delete($this->currentAvatar);
            }
            $validated['avatar'] = $this->avatar->store('avatars', 'public');
            $this->currentAvatar = $validated['avatar'];
        } else {
            unset($validated['avatar']);
        }

        if ($user->email !== $validated['email']) {
            $user->email_verified_at = null;
        }

        $user->update($validated);
        $this->avatar = null;
        $this->profileMessage = 'Profile updated successfully.';
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->passwordMessage = 'Password updated successfully.';
    }

    public function deleteAccount(): void
    {
        if (Auth::user()->isAdmin()) {
            return;
        }

        $this->validate([
            'delete_password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();
        Auth::logout();
        $user->delete();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.profile-page');
    }
}
