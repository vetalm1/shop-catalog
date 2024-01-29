<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;


class SectionContent extends Model implements HasMedia
{
    use WithMedia, SortableTrait;

    protected $fillable = ['seo_section_id', 'name', 'type', 'title',
        'description', 'list_title', 'list', 'is_active', 'order_column'];

    public $sortable = [ 'order_column_name' => 'order_column', 'sort_when_creating' => true, ];

    protected $casts = [ 'list' => 'array'];

    public function seoSection(): BelongsTo
    {
        return $this->belongsTo(SeoSection::class);
    }

    public function scopeType($query, $value) // text-block/list
    {
        $query->where('type', $value);
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }

    public function scopeSort($query)
    {
        return $query->orderBy('order_column');
    }
}
