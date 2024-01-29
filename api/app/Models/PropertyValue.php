<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;

class PropertyValue extends Model
{
    use SortableTrait;

    protected $table = 'property_values';

    protected $fillable = ['product_id', 'property_id', 'value', 'is_sync'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
