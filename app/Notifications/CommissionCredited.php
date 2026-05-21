<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Commission;

class CommissionCredited extends Notification
{
    use Queueable;

    public function __construct(protected Commission $commission) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $serviceName = optional($this->commission->order?->service)->name ?? 'a service';
        $amount      = number_format($this->commission->amount, 2);

        return [
            'type'    => 'commission_credited',
            'icon'    => 'indian-rupee',
            'color'   => 'emerald',
            'title'   => '₹' . $amount . ' Commission Credited!',
            'message' => 'Your commission for "' . $serviceName . '" has been approved and added to your wallet.',
            'amount'  => $this->commission->amount,
            'url'     => route('partner.earnings'),
        ];
    }
}

