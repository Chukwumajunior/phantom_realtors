<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MerchantApprovedNotification extends Notification
{
    public function __construct(
        public ?Subscription $subscription = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Merchant Application Approved!')
            ->greeting("Congratulations {$notifiable->name}!")
            ->line('Your merchant application has been approved. You can now start listing properties, products, and services on Phantom 5.');

        if ($this->subscription) {
            $planName = $this->subscription->plan?->name ?? 'Subscription';
            $expiresAt = $this->subscription->expires_at->format('F d, Y');
            $message->line("Your **{$planName}** has been activated and is valid until **{$expiresAt}**.");
        }

        return $message
            ->action('Go to Merchant Dashboard', url('/merchant/dashboard'))
            ->line('If you have any questions, contact us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
