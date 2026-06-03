<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ['service_id', 'section', 'name', 'image', 'link', 'youtube_url', 'google_drive_url', 'is_active'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
