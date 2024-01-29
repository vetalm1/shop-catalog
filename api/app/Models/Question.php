<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = ['type', 'name', 'phone', 'email', 'question', 'is_viewed', ];

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }

    public function scopeIsViewed($query)
    {
        $query->where('is_viewed', true);
    }
}
