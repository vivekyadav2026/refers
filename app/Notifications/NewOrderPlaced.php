<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class NewOrderPlaced extends Notification
{
    use Queueable;

    public function __construct(protected Order $order) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $serviceName = optional($this->order->service)->name ?? 'Custom Service';
        return [
            'type'       => 'new_order',
            'icon'       => 'shopping-bag',
            'color'      => 'blue',
            'title'      => 'New Order #ORD-' . str_pad($this->order->id, 5, '0', STR_PAD_LEFT),
            'message'    => ($this->order->customer_name ?? optional($this->order->user)->name ?? 'A customer') . ' ordered ' . $serviceName,
            'amount'     => $this->order->amount,
            'url'        => route('admin.orders.show', $this->order->id),
        ];
    }
}
