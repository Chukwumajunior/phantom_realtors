<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionCancelledNotification extends Notification
{
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Subscription Cancelled')
            ->greeting("Hello {$notifiable->name},")
            ->line('Your subscription on Phantom 5 has been cancelled by the admin.')
            ->line('Your listings are no longer visible to the public and you cannot create or edit listings.')
            ->line('If you believe this is an error, please contact us immediately.')
            ->action('Contact Support', 'mailto:info@phantom5.com.ng')
            ->line('For enquiries, reach us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
