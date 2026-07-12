<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $request->user()->fill($data);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $imageService = app(ImageService::class);

        // Delete avatar file
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Soft-delete listings and remove their image files
        foreach ($user->properties as $property) {
            $imageService->deleteAllImages($property);
            $property->delete();
        }
        foreach ($user->products as $product) {
            $imageService->deleteAllImages($product);
            $product->delete();
        }
        foreach ($user->services as $service) {
            $imageService->deleteAllImages($service);
            $service->delete();
        }

        // Delete merchant profile files and record
        if ($profile = $user->merchantProfile) {
            foreach (['logo', 'cac_document', 'payment_proof'] as $field) {
                if ($profile->$field && Storage::disk('public')->exists($profile->$field)) {
                    Storage::disk('public')->delete($profile->$field);
                }
            }
            $profile->delete();
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
