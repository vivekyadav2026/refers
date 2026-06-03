<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_uses',
        'current_uses',
        'expires_at',
        'is_active',
        'service_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Check if the coupon is valid for a given amount and service.
     */
    public function isValid($amount = 0, $serviceId = null)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses && $this->current_uses >= $this->max_uses) {
            return false;
        }

        if ($this->min_order_amount && $amount < $this->min_order_amount) {
            return false;
        }

        // If coupon is service-specific, check if service matches
        if ($this->service_id && $serviceId && $this->service_id != $serviceId) {
            return false;
        }

        return true;
    }

    /**
     * Calculate the discount amount.
     */
    public function calculateDiscount($amount, $serviceId = null)
    {
        if (!$this->isValid($amount, $serviceId)) {
            return 0;
        }

        if ($this->discount_type === 'percent') {
            return ($amount * $this->discount_value) / 100;
        }

        return min($this->discount_value, $amount);
    }
}
