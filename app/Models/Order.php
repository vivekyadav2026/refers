<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['lead_id', 'user_id', 'service_id', 'amount', 'status', 'requirements'];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
