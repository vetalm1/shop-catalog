<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;

class ClientFeedback extends Model implements HasMedia
{
    use SortableTrait, WithMedia;

    protected $table = 'client_feedbacks';

    protected $fillable = ['name', 'position', 'company_name', 'company_title', 'short_text', 'text',
        'order_column', 'is_active'];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }

    public function scopeSort($query)
    {
        return $query->orderBy('order_column');
    }
}
