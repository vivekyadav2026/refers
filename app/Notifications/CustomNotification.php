<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CustomNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $title,
        protected string $message,
        protected ?string $url = null,
        protected string $icon = 'bell',
        protected string $color = 'violet'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'custom_notification',
            'icon'    => $this->icon ?: 'bell',
            'color'   => $this->color ?: 'violet',
            'title'   => $this->title,
            'message' => $this->message,
            'url'     => $this->url ?: url('/'),
        ];
    }
}
