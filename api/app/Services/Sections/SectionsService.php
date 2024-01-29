<?php

namespace App\Services\Sections;

use App\Models\SeoSection;

class SectionsService
{
    public function getSeoSection($pageName): SeoSection|null
    {
        return SeoSection::getSeoSection($pageName);
    }
}
