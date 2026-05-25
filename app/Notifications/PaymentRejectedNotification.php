<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRejectedNotification extends Notification
{
    public function __construct(
        public Payment $payment,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Payment Rejected - Order #' . $this->payment->order->order_number)
            ->greeting("Hello {$notifiable->name},")
            ->line('Unfortunately, your payment could not be verified.')
            ->line("**Order:** #{$this->payment->order->order_number}")
            ->line("**Amount:** ₦" . number_format($this->payment->amount, 2));

        if ($this->payment->admin_notes) {
            $message->line("**Reason:** {$this->payment->admin_notes}");
        }

        return $message
            ->line('Please resubmit your payment with valid proof or contact us for assistance.')
            ->action('View Order', url('/customer/orders/' . $this->payment->order_id))
            ->line('If you have any questions, contact us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
