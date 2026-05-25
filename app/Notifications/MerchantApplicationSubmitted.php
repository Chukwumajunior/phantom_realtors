<?php

namespace App\Notifications;

use App\Models\SubscriptionPlan;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MerchantApplicationSubmitted extends Notification
{
    public function __construct(
        public ?SubscriptionPlan $plan = null,
        public ?string $amountPaid = null,
        public bool $isResubmission = false,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject($this->isResubmission ? 'Application Resubmitted' : 'Merchant Application Received')
            ->greeting("Hello {$notifiable->name},");

        if ($this->isResubmission) {
            $message->line('Your merchant application has been resubmitted for review.')
                ->line('We will review your updated information and get back to you shortly.');
        } else {
            $message->line('Thank you for applying to become a merchant on Phantom 5!')
                ->line('We have received your application along with your payment details:')
                ->line("**Plan:** {$this->plan?->name}")
                ->line("**Amount:** ₦" . number_format((float) $this->amountPaid, 2))
                ->line('Your application is now under review. You will be notified once it is approved.');
        }

        return $message
            ->line('If you have any questions, contact us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
