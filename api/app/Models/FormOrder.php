<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormOrder extends Model
{
    protected $table = 'form_orders';

    protected $fillable = ['type', 'product_id', 'product_name', 'name', 'quantity', 'company_name', 'phone',
        'email', 'comment', 'is_viewed', ];

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }

    public function scopeIsViewed($query)
    {
        $query->where('is_viewed', true);
    }
}
