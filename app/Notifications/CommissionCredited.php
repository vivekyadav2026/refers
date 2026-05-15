<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;
use App\Models\Commission;

class CommissionCredited extends Notification implements ShouldQueue
{
    use Queueable;

    protected $commission;

    public function __construct(Commission $commission)
    {
        $this->commission = $commission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['mail', 'database'];
        
        // Optionally enable SMS if phone is present and configured
        // if ($notifiable->phone && env('VONAGE_KEY')) {
        //     $channels[] = 'vonage';
        // }
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Commission Credited: $' . number_format($this->commission->amount, 2))
                    ->greeting('Cha-ching! Hello ' . $notifiable->name . ',')
                    ->line('A commission of $' . number_format($this->commission->amount, 2) . ' has been credited to your wallet for the ' . $this->commission->order->lead->client_name . ' project.')
                    ->action('View Wallet', url('/earnings'))
                    ->line('Keep up the great work!');
    }

    public function toVonage(object $notifiable): VonageMessage
    {
        return (new VonageMessage)
                    ->content('VivekTech: A commission of $' . number_format($this->commission->amount, 2) . ' has been credited to your wallet. Check your dashboard!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'commission_credited',
            'commission_id' => $this->commission->id,
            'amount' => $this->commission->amount,
            'client_name' => $this->commission->order->lead->client_name,
            'message' => 'Commission of $' . number_format($this->commission->amount, 2) . ' credited.',
        ];
    }
}
