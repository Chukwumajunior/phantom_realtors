<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Notifications\SubscriptionActivatedNotification;
use App\Notifications\SubscriptionCancelledNotification;
use Illuminate\Http\Request;

class SubscriptionManagementController extends Controller
{
    public function index()
    {
        $merchants = User::where('role', UserRole::Merchant)
            ->with(['merchantProfile', 'subscriptions' => function ($q) {
                $q->latest('expires_at')->limit(1);
            }])
            ->latest()
            ->paginate(15);

        $plans = SubscriptionPlan::active()->orderBy('price')->get();

        return view('admin.subscriptions.index', compact('merchants', 'plans'));
    }

    public function activate(Request $request, User $user)
    {
        $request->validate([
            'subscription_plan_id' => ['required', 'exists:subscription_plans,id'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $plan = SubscriptionPlan::findOrFail($request->subscription_plan_id);

        // Expire any currently active subscriptions
        $user->subscriptions()
            ->active()
            ->update(['status' => SubscriptionStatus::Expired->value]);

        // Create new subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'status' => SubscriptionStatus::Active,
            'starts_at' => now(),
            'expires_at' => now()->addDays($plan->duration_days),
            'activated_at' => now(),
            'activated_by' => auth()->id(),
            'admin_notes' => $request->admin_notes,
        ]);

        $user->notify(new SubscriptionActivatedNotification($subscription));

        return back()->with('success', "Subscription activated for {$user->name} ({$plan->name}).");
    }

    public function cancel(Request $request, User $user)
    {
        $activeSubscription = $user->subscriptions()->active()->first();

        if (!$activeSubscription) {
            return back()->with('error', 'No active subscription to cancel.');
        }

        $activeSubscription->update([
            'status' => SubscriptionStatus::Cancelled,
        ]);

        $user->notify(new SubscriptionCancelledNotification);

        return back()->with('success', "Subscription cancelled for {$user->name}.");
    }
}
