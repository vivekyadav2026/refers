<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostPaymentDetail extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'service_name',
        'data',
        'uploaded_files',
    ];

    protected $casts = [
        'data' => 'array',
        'uploaded_files' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
