<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewMemberRegistered extends Notification
{
    use Queueable;

    public function __construct(protected User $member) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable)
    {
        $role = ucfirst($this->member->role);
        return (new \Illuminate\Notifications\Messages\MailMessage)
                    ->subject('New ' . $role . ' Registration')
                    ->greeting('Hello Admin,')
                    ->line('A new ' . $role . ' has just registered on the platform.')
                    ->line('Name: ' . ($this->member->name ?? 'Unknown'))
                    ->line('Phone: ' . $this->member->phone)
                    ->action('View Profile', route('admin.users.show', $this->member->id))
                    ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $role = ucfirst($this->member->role);
        return [
            'type'    => 'new_member',
            'icon'    => 'user-plus',
            'color'   => 'emerald',
            'title'   => 'New ' . $role . ' Registered',
            'message' => ($this->member->name ?? 'Someone') . ' just joined as a ' . $role,
            'url'     => route('admin.users.show', $this->member->id),
        ];
    }
}
