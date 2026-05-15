<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class PaymentSuccessful extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Payment Received: ' . $this->order->lead->client_name)
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('Great news! We have successfully received payment for the ' . $this->order->lead->client_name . ' project.')
                    ->line('Amount Paid: $' . number_format($this->order->amount, 2))
                    ->action('View Earnings', url('/earnings'))
                    ->line('Your commission will be credited shortly.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'payment_successful',
            'order_id' => $this->order->id,
            'client_name' => $this->order->lead->client_name,
            'amount' => $this->order->amount,
            'message' => 'Payment captured for ' . $this->order->lead->client_name,
        ];
    }
}
