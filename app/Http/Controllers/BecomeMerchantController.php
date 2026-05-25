<?php

namespace App\Http\Controllers;

use App\Enums\MerchantStatus;
use App\Enums\UserRole;
use App\Models\SubscriptionPlan;
use App\Notifications\MerchantApplicationSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $profile = $user->merchantProfile;

        // If pending, can't resubmit
        if ($profile && $profile->isPending()) {
            return redirect()->route('home')
                ->with('info', 'Your merchant application is already pending review.');
        }

        // If rejected, allow resubmission (pre-fill form)
        $plans = SubscriptionPlan::active()->orderBy('price')->get();

        return view('become-seller', compact('plans', 'profile'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->isMerchant() || $user->isAdmin()) {
            return redirect()->route('home');
        }

        $existingProfile = $user->merchantProfile;

        // If pending, can't resubmit
        if ($existingProfile && $existingProfile->isPending()) {
            return redirect()->route('home')
                ->with('info', 'Your merchant application is already pending review.');
        }

        // If rejected, this is a resubmission (no payment needed again)
        $isResubmission = $existingProfile && $existingProfile->status === MerchantStatus::Rejected;

        $rules = [
            'business_name' => ['required', 'string', 'max:255'],
            'business_phone' => ['nullable', 'string', 'max:20'],
            'business_description' => ['nullable', 'string', 'max:2000'],
            'business_address' => ['nullable', 'string', 'max:500'],
            'passport_photo' => [$user->avatar ? 'nullable' : 'required', 'image', 'max:2048'],
        ];

        // Only require payment on first submission
        if (!$isResubmission) {
            $rules['subscription_plan_id'] = ['required', 'exists:subscription_plans,id'];
            $rules['payment_proof'] = ['required', 'image', 'max:5120'];
            $rules['payment_reference'] = ['nullable', 'string', 'max:255'];
        }

        $request->validate($rules);

        // Store passport photo as user avatar
        if ($request->hasFile('passport_photo')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->update([
                'avatar' => $request->file('passport_photo')->store('avatars', 'public'),
            ]);
        }

        if ($isResubmission) {
            // Update existing profile (keep payment details intact)
            $existingProfile->update([
                'business_name' => $request->business_name,
                'business_description' => $request->business_description,
                'business_phone' => $request->business_phone ?? $user->phone,
                'business_address' => $request->business_address,
                'status' => MerchantStatus::Pending,
                'rejection_reason' => null,
            ]);

            $user->notify(new MerchantApplicationSubmitted(isResubmission: true));

            return redirect()->route('home')
                ->with('success', 'Your merchant application has been resubmitted for review.');
        }

        // First-time submission: require payment
        $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        $plan = SubscriptionPlan::findOrFail($request->subscription_plan_id);

        $user->merchantProfile()->create([
            'business_name' => $request->business_name,
            'business_description' => $request->business_description,
            'business_phone' => $request->business_phone ?? $user->phone,
            'business_address' => $request->business_address,
            'status' => MerchantStatus::Pending,
            'subscription_plan_id' => $plan->id,
            'payment_proof' => $paymentProofPath,
            'payment_reference' => $request->payment_reference,
            'amount_paid' => $plan->price,
        ]);

        $user->notify(new MerchantApplicationSubmitted(plan: $plan, amountPaid: $plan->price));

        return redirect()->route('home')
            ->with('success', 'Your merchant application has been submitted with payment proof. You will be notified once approved.');
    }
}
