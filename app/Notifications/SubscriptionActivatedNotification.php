<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionActivatedNotification extends Notification
{
    public function __construct(
        public Subscription $subscription,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $planName = $this->subscription->plan?->name ?? 'N/A';
        $expiresAt = $this->subscription->expires_at->format('F d, Y');

        return (new MailMessage)
            ->subject('Subscription Activated')
            ->greeting("Hello {$notifiable->name},")
            ->line('Your subscription has been activated successfully!')
            ->line("**Plan:** {$planName}")
            ->line("**Valid Until:** {$expiresAt}")
            ->line('You can now create and manage your listings on Phantom 5.')
            ->action('Go to Dashboard', url('/merchant/dashboard'))
            ->line('If you have any questions, contact us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
