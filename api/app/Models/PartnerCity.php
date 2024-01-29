<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerCity extends Model
{
    protected $fillable = ['point_x', 'point_y', 'coords', 'city', 'title', 'text', 'is_active',];

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }
}
