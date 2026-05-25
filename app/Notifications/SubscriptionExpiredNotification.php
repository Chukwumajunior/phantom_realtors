<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiredNotification extends Notification
{
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Subscription Expired')
            ->greeting("Hello {$notifiable->name},")
            ->line('Your subscription on Phantom 5 has expired.')
            ->line('As a result:')
            ->line('- Your listings are no longer visible to the public')
            ->line('- You cannot create or edit listings')
            ->line('- Your existing orders remain accessible')
            ->line('To reactivate your listings, please renew your subscription by making payment and contacting the admin.')
            ->action('View Subscription Details', url('/merchant/subscription'))
            ->line('For payment and renewal, contact us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
