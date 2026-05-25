<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    public function __construct(
        public Order $order,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order Received - #' . $this->order->order_number)
            ->greeting("Hello {$notifiable->name},")
            ->line('You have received a new order!')
            ->line("**Order:** #{$this->order->order_number}")
            ->line("**Customer:** {$this->order->customer->name}")
            ->line("**Total:** ₦" . number_format($this->order->total_amount, 2))
            ->line("**Items:** {$this->order->items->count()}")
            ->action('View Order', url('/merchant/orders/' . $this->order->id))
            ->line('You will be notified once the customer submits payment.')
            ->salutation('— The Phantom 5 Team');
    }
}
