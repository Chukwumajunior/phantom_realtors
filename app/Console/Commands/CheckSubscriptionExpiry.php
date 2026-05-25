<?php

namespace App\Console\Commands;

use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use App\Notifications\SubscriptionExpiredNotification;
use App\Notifications\SubscriptionExpiringSoonNotification;
use Illuminate\Console\Command;

class CheckSubscriptionExpiry extends Command
{
    protected $signature = 'subscriptions:check-expiry';
    protected $description = 'Check for expiring and expired subscriptions and notify merchants';

    public function handle(): void
    {
        // Notify merchants whose subscriptions expire in 3 days
        $expiringSoon = Subscription::with('user')
            ->whereIn('status', [SubscriptionStatus::Active->value])
            ->whereDate('expires_at', now()->addDays(3)->toDateString())
            ->get();

        foreach ($expiringSoon as $subscription) {
            $subscription->user->notify(new SubscriptionExpiringSoonNotification($subscription));
        }

        // Mark expired subscriptions and notify
        $expired = Subscription::with('user')
            ->whereIn('status', [SubscriptionStatus::Active->value])
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expired as $subscription) {
            $subscription->update(['status' => SubscriptionStatus::Expired]);
            $subscription->user->notify(new SubscriptionExpiredNotification);
        }

        $this->info("Processed {$expiringSoon->count()} expiring soon, {$expired->count()} expired.");
    }
}
