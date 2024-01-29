<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class SeoSection extends Model
{
    use Searchable;

    protected $fillable = ['page_name', 'page_description', 'seo_title', 'seo_description', 'is_active'];


    public function toSearchableArray(): array
    {
        $array = $this->toArray();
        $array['type'] = 'section';
        return $array;
    }

    public function sectionContents(): HasMany
    {
        return $this->hasMany(SectionContent::class)->orderBy('order_column')->orderBy('id');
    }

    public function scopePageName($query, $value)
    {
        $query->where('page_name', $value);
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', true);
    }

    public function scopeSection($query, $section_name)
    {
        $query->where('page_name', $section_name);
    }

    public static function getSeoSection($pageName): SeoSection|null
    {
        return SeoSection::pageName($pageName)->first();
    }
}
