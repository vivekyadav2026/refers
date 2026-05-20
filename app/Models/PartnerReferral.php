<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerReferral extends Model
{
    protected $fillable = [
        'partner_id', 'customer_id', 'order_id',
        'referral_code', 'ip_address', 'status'
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
