<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
    protected $fillable = [
        'user_id',
        'aadhaar_path',
        'pan_path',
        'photo_path',
        'bank_details',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'bank_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
