<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to Phantom 5')
            ->greeting("Hello {$notifiable->name},")
            ->line('Welcome to Phantom 5! Your account has been created successfully.')
            ->line('You can now browse properties, products, and services from verified merchants.')
            ->line('Interested in selling? You can apply to become a merchant from your dashboard.')
            ->action('Visit Your Dashboard', url('/'))
            ->line('If you have any questions, contact us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
