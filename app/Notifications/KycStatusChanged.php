<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\KycDocument;

class KycStatusChanged extends Notification
{
    use Queueable;

    public function __construct(protected KycDocument $kyc, protected string $newStatus) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $isApproved = $this->newStatus === 'approved';
        return [
            'type'    => 'kyc_status',
            'icon'    => $isApproved ? 'shield-check' : 'shield-x',
            'color'   => $isApproved ? 'emerald' : 'red',
            'title'   => 'KYC ' . ucfirst($this->newStatus),
            'message' => 'KYC for ' . ($this->kyc->user->name ?? 'a partner') . ' was ' . $this->newStatus,
            'url'     => route('admin.kyc.show', $this->kyc->id),
        ];
    }
}
