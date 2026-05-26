<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'business_name',
        'domain_name',
        'logo_path',
        'product_images',
        'support_phone',
        'support_email',
        'office_address',
        'extra_details'
    ];

    protected $casts = [
        'product_images' => 'array',
        'extra_details' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
