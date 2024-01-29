<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PropertyGroup extends Model
{
    use HasSlug, SortableTrait;

    protected $fillable = ['name', 'slug', 'order_column', 'is_active'];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }
}
