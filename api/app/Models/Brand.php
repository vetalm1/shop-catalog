<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Brand extends Model implements HasMedia
{
    use HasFactory, HasSlug, WithMedia;

    protected $fillable = ['name', 'slug', 'sync_uuid', 'title', 'description', 'show_on_main',
        'is_active', 'seo_title', 'seo_description',];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /*
    |--------------------------------------------------------------------------
    | Functions
    |--------------------------------------------------------------------------
    */

    /** php artisan scout:import "App\Models\Brand" */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();
        $array['type'] = 'brands';
        return $array;
    }

    public function searchableAs(): string
    {
        return 'brands';
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeMain($query)
    {
        return $query->where('show_on_main', true);
    }

    public function scopeGetBrandByQuery($query, $brand)
    {
        if ($brand) {
            return $query->where('name', 'ilike', '%' . $brand . '%');
        }
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFilterByCategory($query, $categoryId)
    {
        $query->whereHas('products', function ($query) use ($categoryId) {
            $query->whereHas('categories', function ($query) use ($categoryId) {
                $query->whereIn('category_id', Category::descendantsAndSelf($categoryId)->pluck('id'));
            });
        });
    }

    public function scopeFilterByProductIdArr($query, $productIdArr)
    {
        $query->whereHas('products', function ($query) use ($productIdArr) {
            $query->whereIn('products.id', $productIdArr);

        });
    }
    public function scopeSort($query, $type)
    {
        switch ($type) {
            case 'name':
                break;
            case 'products_count':
                $query->orderBy('products_count', 'desc');
                break;
        }
        $query->orderBy('name');
    }
}
