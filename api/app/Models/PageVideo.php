<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;

class PageVideo extends Model implements HasMedia
{
    use SortableTrait, WithMedia;

    protected $fillable = ['page', 'button_text', 'link', 'is_active', 'order_column'];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];


    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }

    public function scopePage($query, $page)
    {
        $query->where('page', $page);
    }
}
