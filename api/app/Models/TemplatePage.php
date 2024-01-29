<?php

namespace App\Models;

use App\Support\MediaLibrary\WithMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class TemplatePage extends Model implements HasMedia
{
    use WithMedia;

    protected $table = 'template_pages';

    protected $fillable = ['name', 'slug', 'title', 'description', 'seo_title', 'seo_description', 'is_active'];

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }
}
