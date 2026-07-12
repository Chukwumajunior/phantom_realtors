<?php

namespace App\Http\Controllers;

use App\Enums\MerchantStatus;
use App\Enums\PosterTier;
use App\Enums\UserRole;
use App\Models\SiteConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosterProfileController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        if ($user->merchantProfile) {
            return redirect()->route('merchant.dashboard');
        }

        $tiers = PosterTier::cases();
        $tierSettings = SiteConfig::getTierSettings();
        $bankDetails = SiteConfig::getBankDetails();

        return view('merchant.setup', compact('tiers', 'tierSettings', 'bankDetails'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->merchantProfile) {
            return redirect()->route('merchant.dashboard');
        }

        $tier = PosterTier::from($request->tier);

        // Base validation rules (all tiers)
        $rules = [
            'tier' => ['required', 'in:tier_1,tier_2,tier_3'],
            'business_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'passport_photo' => [$user->avatar ? 'nullable' : 'required', 'image', 'max:2048'],
            'house_number' => ['required', 'string', 'max:50'],
            'street_name' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:100'],
            'lga' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
        ];

        // Paid tiers require payment proof
        if (! $tier->isFree()) {
            $rules['payment_proof'] = ['required', 'image', 'max:5120'];
            $rules['payment_reference'] = ['nullable', 'string', 'max:255'];
        }

        // Tier 3 additional requirements
        if ($tier->requiresCompanyName()) {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['cac_document'] = ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'];
        }

        $request->validate($rules);

        // Upload passport photo if provided
        if ($request->hasFile('passport_photo')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->update([
                'avatar' => $request->file('passport_photo')->store('avatars', 'public'),
            ]);
        }

        // Update phone on user
        if (! $user->phone || $request->phone !== $user->phone) {
            $user->update(['phone' => $request->phone]);
        }

        // Upload CAC document if provided
        $cacPath = null;
        if ($request->hasFile('cac_document')) {
            $cacPath = $request->file('cac_document')->store('cac_documents', 'public');
        }

        // Upload payment proof if provided
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Determine status: free tiers are auto-approved, paid tiers are pending
        $status = $tier->isFree() ? MerchantStatus::Approved : MerchantStatus::Pending;

        // Create the poster profile
        $user->merchantProfile()->create([
            'business_name' => $request->business_name,
            'business_phone' => $request->phone,
            'status' => $status,
            'tier' => $tier,
            'company_name' => $request->company_name,
            'cac_document' => $cacPath,
            'payment_proof' => $paymentProofPath,
            'payment_reference' => $request->payment_reference,
            'house_number' => $request->house_number,
            'street_name' => $request->street_name,
            'area' => $request->area,
            'lga' => $request->lga,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country ?? 'Nigeria',
        ]);

        // Upgrade user role to merchant
        $user->update(['role' => UserRole::Merchant]);

        if ($tier->isFree()) {
            return redirect()->route('merchant.dashboard')
                ->with('success', 'Your posting profile is ready! You can now create listings.');
        }

        return redirect()->route('merchant.dashboard')
            ->with('info', 'Your profile has been submitted. Once payment is confirmed by admin, your ' . $tier->label() . ' features will be activated.');
    }

    public function edit(Request $request)
    {
        $profile = $request->user()->merchantProfile;
        $tiers = PosterTier::cases();
        $tierSettings = SiteConfig::getTierSettings();
        $bankDetails = SiteConfig::getBankDetails();

        return view('merchant.profile.edit', compact('profile', 'tiers', 'tierSettings', 'bankDetails'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $profile = $user->merchantProfile;
        $newTier = PosterTier::from($request->tier ?? $profile->tier->value);
        $isUpgrade = $newTier->value !== $profile->tier->value && ! $newTier->isFree();

        $rules = [
            'business_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'house_number' => ['required', 'string', 'max:50'],
            'street_name' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:100'],
            'lga' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'passport_photo' => ['nullable', 'image', 'max:2048'],
        ];

        // If upgrading to a paid tier, require payment proof
        if ($isUpgrade) {
            $rules['payment_proof'] = ['required', 'image', 'max:5120'];
            $rules['payment_reference'] = ['nullable', 'string', 'max:255'];
        }

        // If upgrading to Tier 3, require company name + CAC
        if ($newTier->requiresCompanyName()) {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            if (! $profile->cac_document) {
                $rules['cac_document'] = ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'];
            }
        }

        $request->validate($rules);

        // Upload passport photo if provided
        if ($request->hasFile('passport_photo')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->update([
                'avatar' => $request->file('passport_photo')->store('avatars', 'public'),
            ]);
        }

        // Update phone
        $user->update(['phone' => $request->phone]);

        // Upload CAC document if provided
        $cacPath = $profile->cac_document;
        if ($request->hasFile('cac_document')) {
            if ($profile->cac_document) {
                Storage::disk('public')->delete($profile->cac_document);
            }
            $cacPath = $request->file('cac_document')->store('cac_documents', 'public');
        }

        // Upload payment proof if provided (for tier upgrades)
        $paymentProofPath = $profile->payment_proof;
        if ($request->hasFile('payment_proof')) {
            if ($profile->payment_proof) {
                Storage::disk('public')->delete($profile->payment_proof);
            }
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $updateData = [
            'business_name' => $request->business_name,
            'business_phone' => $request->phone,
            'company_name' => $request->company_name ?? $profile->company_name,
            'cac_document' => $cacPath,
            'house_number' => $request->house_number,
            'street_name' => $request->street_name,
            'area' => $request->area,
            'lga' => $request->lga,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country ?? 'Nigeria',
        ];

        // If upgrading to a paid tier, set to pending and store payment info
        if ($isUpgrade) {
            $updateData['tier'] = $newTier;
            $updateData['status'] = MerchantStatus::Pending;
            $updateData['payment_proof'] = $paymentProofPath;
            $updateData['payment_reference'] = $request->payment_reference;
        }

        $profile->update($updateData);

        if ($isUpgrade) {
            return back()->with('info', 'Upgrade request submitted. Your ' . $newTier->label() . ' will be activated once payment is confirmed.');
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
