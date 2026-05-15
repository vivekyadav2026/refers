<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Lead;

class LeadUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
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
                    ->subject('Lead Status Updated: ' . $this->lead->client_name)
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('The status of your lead for ' . $this->lead->client_name . ' has been updated to: ' . strtoupper($this->lead->status) . '.')
                    ->action('View Lead Dashboard', url('/leads'))
                    ->line('Thank you for being a great partner!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'lead_updated',
            'lead_id' => $this->lead->id,
            'client_name' => $this->lead->client_name,
            'status' => $this->lead->status,
            'message' => 'Lead ' . $this->lead->client_name . ' is now ' . $this->lead->status,
        ];
    }
}
