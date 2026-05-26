<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    protected $fillable = ['parent_id', 'name', 'slug', 'is_active'];

    public function subcategories()
    {
        return $this->hasMany(BusinessCategory::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(BusinessCategory::class, 'parent_id');
    }
}
