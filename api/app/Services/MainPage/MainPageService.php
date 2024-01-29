<?php

namespace App\Services\MainPage;

use App\Models\MainPagePopularCategory;
use Illuminate\Support\Collection as SupportCollection;

class MainPageService
{
    public function getPopularCategories(): SupportCollection
    {
        return MainPagePopularCategory::sort()->get()->map(function ($item) {return $item->category;});
    }
}
