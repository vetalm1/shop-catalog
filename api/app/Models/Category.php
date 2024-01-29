<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;
use Laravel\Scout\Searchable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model implements HasMedia
{
    use HasFactory, HasSlug, SortableTrait, WithMedia;

    use NodeTrait;

    protected $fillable = ['sync_uuid', 'name', 'slug',
        'title', 'description', 'hidden_description', 'card_short_description',
        'parent_id', '_lft', '_rgt', 'depth',
        'order_column', 'is_active', 'seo_title', 'seo_description',
    ];

    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public $casts = ['popular_queries' => 'array'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function popularCategories(): HasMany
    {
        return $this->hasMany(PopularCategory::class, 'category_id');
    }


    /*
    |--------------------------------------------------------------------------
    | Functions
    |--------------------------------------------------------------------------
    */

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->doNotGenerateSlugsOnUpdate()
            ->saveSlugsTo('slug');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }

    public function scopeWhereHasProductSlug($query, $slug)
    {
        $query->whereHas('products', function ($query) use ($slug) {
            $query->where('products.slug', $slug);
        });
    }
}
