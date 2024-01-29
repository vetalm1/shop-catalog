<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;

class Faq extends Model implements HasMedia
{
    use WithMedia, SortableTrait;

    protected $table = 'faq';

    protected $fillable = ['question', 'answer', 'order_column', 'is_active', ];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }
}
