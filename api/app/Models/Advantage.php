<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;

class Advantage extends Model implements HasMedia
{
    use SortableTrait, WithMedia;

    protected $fillable = ['name', 'type', 'title', 'sub_title', 'text', 'order_column', 'is_active'];

    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }

    public function scopeSort($query)
    {
        return $query->orderBy('order_column');
    }

}
