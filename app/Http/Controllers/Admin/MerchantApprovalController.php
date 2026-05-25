<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MerchantStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\MerchantProfile;
use App\Models\Subscription;
use App\Notifications\MerchantApprovedNotification;
use App\Notifications\MerchantRevisionRequested;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MerchantApprovalController extends Controller
{
    public function index()
    {
        $merchants = MerchantProfile::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.merchants.index', compact('merchants'));
    }

    public function show(MerchantProfile $merchantProfile)
    {
        $merchantProfile->load('user');

        return view('admin.merchants.show', ['merchant' => $merchantProfile]);
    }

    public function approve(MerchantProfile $merchantProfile)
    {
        $merchantProfile->update([
            'status' => MerchantStatus::Approved,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejection_reason' => null,
        ]);

        // Change user role to merchant upon approval
        $merchantProfile->user->update(['role' => UserRole::Merchant]);

        // Activate the subscription based on the plan they paid for at registration
        $subscription = null;
        if ($merchantProfile->subscription_plan_id) {
            $plan = $merchantProfile->subscriptionPlan;

            // Expire any existing subscriptions
            $merchantProfile->user->subscriptions()
                ->active()
                ->update(['status' => SubscriptionStatus::Expired->value]);

            $subscription = Subscription::create([
                'user_id' => $merchantProfile->user_id,
                'subscription_plan_id' => $plan->id,
                'status' => SubscriptionStatus::Active,
                'starts_at' => now(),
                'expires_at' => now()->addDays($plan->duration_days),
                'activated_at' => now(),
                'activated_by' => auth()->id(),
            ]);
        }

        try {
            $merchantProfile->user->notify(new MerchantApprovedNotification($subscription));
        } catch (\Exception $e) {
            Log::warning('Failed to send merchant approval email: ' . $e->getMessage());
        }

        return back()->with('success', "Merchant approved successfully. Subscription activated ({$subscription?->plan?->name}).");
    }

    public function reject(Request $request, MerchantProfile $merchantProfile)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $merchantProfile->update([
            'status' => MerchantStatus::Rejected,
            'rejection_reason' => $request->rejection_reason,
        ]);

        try {
            $merchantProfile->user->notify(new MerchantRevisionRequested($request->rejection_reason));
        } catch (\Exception $e) {
            Log::warning('Failed to send merchant rejection email: ' . $e->getMessage());
        }

        return back()->with('success', 'Revision requested. Merchant has been notified.');
    }
}
