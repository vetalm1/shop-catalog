<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;

class Contact extends Model
{
    use SortableTrait;

    protected $table = 'contacts';

    protected $fillable = ['type', 'place', 'value', 'title', 'order_column', 'is_active', ];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }

    public function scopePlace($query, $place)
    {
        $query->where('place', $place);
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }
}
