<?php

namespace App\Http\Controllers;

use App\Enums\MerchantStatus;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class BecomeMerchantController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        // Already a merchant
        if ($user->isMerchant()) {
            return redirect()->route('merchant.dashboard');
        }

        // Admin can't become merchant
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Already has a pending application
        if ($user->merchantProfile) {
            return redirect()->route('home')
                ->with('info', 'Your merchant application is already pending review.');
        }

        return view('become-seller');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->isMerchant() || $user->isAdmin()) {
            return redirect()->route('home');
        }

        // Already has a pending application
        if ($user->merchantProfile) {
            return redirect()->route('home')
                ->with('info', 'Your merchant application is already pending review.');
        }

        $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'business_phone' => ['nullable', 'string', 'max:20'],
            'business_description' => ['nullable', 'string', 'max:2000'],
            'business_address' => ['nullable', 'string', 'max:500'],
        ]);

        // Create merchant profile but keep role as customer until approved
        $user->merchantProfile()->create([
            'business_name' => $request->business_name,
            'business_description' => $request->business_description,
            'business_phone' => $request->business_phone ?? $user->phone,
            'business_address' => $request->business_address,
            'status' => MerchantStatus::Pending,
        ]);

        return redirect()->route('home')
            ->with('success', 'Your merchant application has been submitted. You will be notified once approved.');
    }
}
