<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type', // image, video, document
        'file_path',
        'is_active',
    ];

    /**
     * Get the full URL to the file.
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
