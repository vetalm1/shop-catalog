<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;

class Slide extends Model implements HasMedia
{
    use SortableTrait, WithMedia;

    protected $fillable = ['slider_id', 'title', 'description',
        'button_text', 'button_link', 'button_background_color', 'button_text_color', 'button_frame_color',
        'is_active', 'order_column',];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function slider(): BelongsTo
    {
        return $this->belongsTo(Slider::class);
    }

    public function scopeIsActive($query, $type)
    {
        $query->where('is_active', $type);
    }
}
