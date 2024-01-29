<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;

class Office extends Model implements HasMedia
{
    use SortableTrait, WithMedia;

    protected $fillable = ['title', 'short_title', 'text', 'city', 'address', 'address_title',
        'phone', 'opening_hours', 'lat', 'lon', 'order_column', 'is_active'];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public $casts = ['emails' => 'array' ];

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }

    public function scopeSort($query)
    {
        return $query->orderBy('order_column');
    }
}
