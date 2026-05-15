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
        'min_price',
        'icon',
        'is_popular',
        'is_active',
        'features',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_active'  => 'boolean',
        'features'   => 'array',
        'min_price'  => 'decimal:2',
    ];
}
