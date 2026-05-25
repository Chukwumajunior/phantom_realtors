<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentConfirmedNotification extends Notification
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
        return (new MailMessage)
            ->subject('Payment Confirmed - Order #' . $this->payment->order->order_number)
            ->greeting("Hello {$notifiable->name},")
            ->line('Your payment has been confirmed!')
            ->line("**Order:** #{$this->payment->order->order_number}")
            ->line("**Amount:** ₦" . number_format($this->payment->amount, 2))
            ->line('Your order is now being processed by the merchant.')
            ->action('View Order', url('/customer/orders/' . $this->payment->order_id))
            ->line('If you have any questions, contact us at info@phantom5.com.ng.')
            ->salutation('— The Phantom 5 Team');
    }
}
