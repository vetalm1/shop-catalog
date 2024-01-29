<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\SortableTrait;

class MainPagePopularCategory extends Model
{
    use  SortableTrait;

    protected $fillable = ['title', 'category_id', 'order_column'];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function scopeSort($query)
    {
        return $query->orderBy('order_column');
    }

}
