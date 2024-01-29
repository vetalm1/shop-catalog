<?php

namespace App\Models;

use App\Support\Enums\SliderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slider extends Model
{
    protected $fillable = ['name', 'type', 'title', 'sub_title'];

    protected $casts = [
        'type' => SliderType::class
    ];

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }

    public function scopeWithSlides($query)
    {
        $query->with(['slides' => function ($query) {
            $query->where('is_active', true);
            $query->ordered();
        }]);

    }

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }
}
