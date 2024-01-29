<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Warehouse extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = ['sync_uuid', 'name', 'city', 'address', 'opening_hours', 'phone',
        'lat', 'lon', 'order_column', 'is_active',];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }
}
