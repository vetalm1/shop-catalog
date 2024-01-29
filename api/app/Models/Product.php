<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements HasMedia
{
    use HasFactory, SortableTrait, HasSlug, WithMedia , Searchable;

    protected $fillable = ['sync_uuid', 'sync_color_uuid', 'name', 'slug',
        'description', 'hidden_description', 'art', 'brand_id', 'price', 'balance',
        'is_active', 'created_at_1s', 'delivery_properties', 'order_column',
        'seo_title', 'seo_description',
    ];

    public $casts = ['delivery_properties' => 'array'];

    /*
    |--------------------------------------------------------------------------
    | Functions
    |--------------------------------------------------------------------------
    */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();
        $array['type'] = 'product';
        return $array;
    }

    public function isInStock(): bool
    {
        return (boolean)$this->balance;
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function propertyValues(): HasMany
    {
        return $this->hasMany(PropertyValue::class);
    }

    public function similarProducts(): HasMany
    {
        return $this->hasMany(SimilarProduct::class);
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

    public function scopePositivePrice($query)
    {
        $query->where('price', '>', 0);
    }

    public function scopeSimpleSearch($query, $q)
    {
        if($q) {
            $query->where('art', 'iLike', $q . '%');
            $query->orWhere('name', 'ilike', '%'. $q .'%' );
        }
    }

    public function scopeFilterByCategory($query, $categoryId)
    {
        !$categoryId ?:
            $query->whereHas('categories', function ($query) use ($categoryId) {
                $query->whereIn('category_id', Category::descendantsAndSelf($categoryId)->pluck('id'));
            });
    }

    public function scopeFilterByBrand($query, $brandId)
    {
        !$brandId ?:
            $query->where('brand_id', $brandId);
    }

    public function scopeFilterByProductIdArr($query, $productIdArr)
    {
            $query->whereIn('id', $productIdArr);
    }

    public function scopeFilterByRequest($query, $request)
    {
        if ($request->has('in_stock')) {
            $query->where('balance', '>', 0);
        }

        if ($request->has('art')) {
            $query->where('art', 'iLike', '%' . $request->input('art') . '%');
        }

        if ($request->has('brands')) {
            $brands = $request->input('brands', []);

            if (count($brands)) {
                $query->whereHas('brand', function ($query) use ($brands) {
                    $query->whereIn('brands.slug', $brands);
                });
            }
        }

        if ($request->hasAny(['price_min', 'price_max'])) {
            $priceMin = $request->input('price_min', 0);
            $priceMax = $request->input('price_max');

            $query->whereBetween('price', [$priceMin, $priceMax]);
        }

        if ($request->has('filters')) {
            $filters = $request->input('filters');
            $this->addPropFiltersToQuery($query, $filters);
        }
    }

    protected function addPropFiltersToQuery($query, $filters)
    {
        foreach ($filters as $key => $value) {

            if (Str::endsWith($key, '_min')) {
                $key = substr($key, 0, -4);
                $query->whereHas('propertyValues', function ($query) use ($key, $value) {
                    $query->whereHas('property', function ($query) use ($key) {
                        $query->where('slug', $key);
                    });
                    $query->where('numeric_value', '>=', $value);
                });
            } else if (Str::endsWith($key, '_max')) {
                $key = substr($key, 0, -4);
                $query->whereHas('propertyValues', function ($query) use ($key, $value) {
                    $query->whereHas('property', function ($query) use ($key) {
                        $query->where('slug', $key);
                    });
                    $query->where('numeric_value', '<=', $value);
                });
            } else {
                $query->whereHas('propertyValues', function ($query) use ($key, $value) {
                    $query->whereHas('property', function ($query) use ($key) {
                        $query->where('slug', $key);
                    });
                    if (is_array($value)) {

                        $query->where(function ($query) use ($value) {
                            $query->whereIn('property_values.value', $value);

                            foreach ($value as $item) {
                                $decodeItem = rawurldecode($item);
                                $query->orWhere('property_values.value', 'iLIKE', '%' . $decodeItem . '%');
                            }
                        });

                    } else {
                        $query->where('property_values.value', $value);
                    }
                });
            }
        }
    }

    public function scopeSort($query, $type)
    {
        switch ($type) {
            case 'price_up':
                $query->orderBy('price', 'asc');
                break;
            case 'price_down':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            default;
                $query->orderByRaw('CASE WHEN balance = 0 THEN 2 ELSE 1 END');
                $query->latest();
                break;
        }
    }
}
