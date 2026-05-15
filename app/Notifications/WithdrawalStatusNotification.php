<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Withdrawal;

class WithdrawalStatusNotification extends Notification
{
    use Queueable;

    protected $withdrawal;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Withdrawal Request Update - SK Solutions')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('Your withdrawal request for ₹' . number_format($this->withdrawal->amount, 2) . ' has been marked as: ' . strtoupper($this->withdrawal->status) . '.')
                    ->action('View Withdrawals', url('/withdrawals'))
                    ->line('Thank you for your partnership!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'withdrawal_id' => $this->withdrawal->id,
            'status' => $this->withdrawal->status
        ];
    }
}
