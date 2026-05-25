<?php

namespace App\Livewire\Admin;

use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Notifications\SubscriptionActivatedNotification;
use App\Notifications\SubscriptionCancelledNotification;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class SubscriptionManagement extends Component
{
    use WithPagination;

    public string $message = '';
    public string $messageType = '';
    public array $selectedPlans = [];

    public function activate(int $userId, int $planId): void
    {
        if (!$planId) {
            $this->message = 'Please select a plan first.';
            $this->messageType = 'error';
            return;
        }

        $user = User::findOrFail($userId);
        $plan = SubscriptionPlan::findOrFail($planId);

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
        ]);

        $user->notify(new SubscriptionActivatedNotification($subscription));

        $this->message = "Subscription activated for {$user->name} ({$plan->name}).";
        $this->messageType = 'success';
        $this->selectedPlans = [];
    }

    public function cancel(int $userId): void
    {
        $user = User::findOrFail($userId);
        $activeSubscription = $user->subscriptions()->active()->first();

        if (!$activeSubscription) {
            $this->message = 'No active subscription to cancel.';
            $this->messageType = 'error';
            return;
        }

        $activeSubscription->update([
            'status' => SubscriptionStatus::Cancelled,
        ]);

        $user->notify(new SubscriptionCancelledNotification);

        $this->message = "Subscription cancelled for {$user->name}.";
        $this->messageType = 'success';
    }

    public function render()
    {
        $merchants = User::where('role', UserRole::Merchant)
            ->with(['merchantProfile', 'subscriptions' => function ($q) {
                $q->latest('expires_at')->limit(1);
            }])
            ->latest()
            ->paginate(15);

        $plans = SubscriptionPlan::active()->orderBy('price')->get();

        return view('livewire.admin.subscription-management', compact('merchants', 'plans'))
            ->title('Merchant Subscriptions');
    }
}
