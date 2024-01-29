<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Property extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['name', 'more_info', 'slug', 'sync_uuid', 'is_main', 'is_active', 'is_in_filter'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'property_values');
    }

    public function propertyValues(): HasMany
    {
        return $this->hasMany(PropertyValue::class);
    }

    public function propertyGroup(): BelongsTo
    {
        return $this->belongsTo(PropertyGroup::class);
    }

    public function scopeIsMain($query)
    {
        $query->where('is_main', true);
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }

    public function scopeIsInFilter($query)
    {
        $query->where('is_in_filter', true);
    }

    public function scopeFilterByBrand($query, $brandId)
    {
        !$brandId ?:
            $query->whereHas('products', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            });
    }

    public function scopeFilterByProductIdArr($query, $productIdArr)
    {
        $query->whereHas('products', function ($query) use ($productIdArr) {
            $query->whereIn('products.id', $productIdArr);
        });
    }

    public function scopeFiltersProperties($query, Category $category)
    {
        /* отбор характеристик и их значений для фильтров, с учетом категории */

        $categoryIdArr = Category::descendantsAndSelf($category->id)
            ->toFlatTree()
            ->pluck('id')
            ->toArray();

        $productIdsArr = Product::query()
            ->positivePrice()->isActive()
            ->whereHas('categories', function ($query) use ($categoryIdArr) {
                $query->whereIn('category_id', $categoryIdArr);
            })
            ->pluck('id')->toArray();

        return $query->whereHas('propertyValues', function ($query) use ($productIdsArr) {
            $query->whereIn('product_id', $productIdsArr);
        })
            ->with(['propertyValues' => function ($query) use ($productIdsArr) {
                $query->whereIn('product_id', $productIdsArr);
                $query->distinct('property_id', 'value');
            }]);
    }
}
