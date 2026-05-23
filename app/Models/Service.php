<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'category',
        'name',
        'short_description',
        'description',
        'min_price',
        'icon',
        'banner_image',
        'delivery_timeline',
        'is_popular',
        'is_active',
        'features',
        'plans',
        'faqs',
        'portfolio',
        'requirements_text',
        'commission_rate',
        'commission_type',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_active'  => 'boolean',
        'features'   => 'array',
        'plans'      => 'array',
        'faqs'       => 'array',
        'min_price'  => 'decimal:2',
        'commission_rate' => 'decimal:2',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Calculate commission amount for this service.
     */
    public function getCommissionAmount(): float
    {
        $rate = $this->commission_rate ?? Setting::get_val('default_commission', 20);
        
        if ($this->commission_type === 'fixed') {
            return (float) $rate;
        }
        
        return $this->min_price * ($rate / 100);
    }
}
