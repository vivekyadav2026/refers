<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'partner_id',
        'client_name',
        'client_email',
        'client_phone',
        'company_name',
        'service_needed',
        'estimated_value',
        'notes',
        'status',
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
