<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiringSoonNotification extends Notification
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
        $daysRemaining = $this->subscription->daysRemaining();
        $expiresAt = $this->subscription->expires_at->format('F d, Y');

        return (new MailMessage)
            ->subject("Subscription Expiring in {$daysRemaining} Days")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your subscription will expire in **{$daysRemaining} days** (on {$expiresAt}).")
            ->line('Once expired, your listings will be hidden from public view and you will not be able to create or edit listings.')
            ->line('To avoid interruption, please renew your subscription before it expires.')
            ->action('View Subscription', url('/merchant/subscription'))
            ->line('For payment and renewal, contact us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
