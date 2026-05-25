<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $subscription = $user->activeSubscription();
        $allSubscriptions = $user->subscriptions()->with('plan')->latest()->get();
        $plans = SubscriptionPlan::active()->orderBy('price')->get();

        return view('merchant.subscription.index', compact('subscription', 'allSubscriptions', 'plans'));
    }

    public function expired(Request $request)
    {
        $user = $request->user();

        // If user has active subscription, redirect to dashboard
        if ($user->hasActiveSubscription()) {
            return redirect()->route('merchant.dashboard');
        }

        $plans = SubscriptionPlan::active()->orderBy('price')->get();
        $lastSubscription = $user->subscriptions()->latest('expires_at')->first();

        return view('merchant.subscription.expired', compact('plans', 'lastSubscription'));
    }
}
