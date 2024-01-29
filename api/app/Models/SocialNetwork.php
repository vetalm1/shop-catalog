<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;

class SocialNetwork extends Model implements HasMedia
{
    use SortableTrait, WithMedia;

    protected $fillable = ['name', 'title', 'link', 'is_active', 'is_main', 'order_column'];

    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function scopeIsMain($query)
    {
        $query->where('is_main', true);
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }
}
