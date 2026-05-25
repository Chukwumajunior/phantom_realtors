<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MerchantRevisionRequested extends Notification
{
    public function __construct(
        public string $rejectionReason,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Merchant Application — Revision Required')
            ->greeting("Hello {$notifiable->name},")
            ->line('Your merchant application requires some corrections before it can be approved.')
            ->line('**Reason:**')
            ->line($this->rejectionReason)
            ->line('Please update the required information and resubmit your application. You will not need to make another payment.')
            ->action('Resubmit Application', url('/become-seller'))
            ->line('If you have any questions, contact us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
