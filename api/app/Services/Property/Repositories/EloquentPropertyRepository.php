<?php

namespace App\Services\Property\Repositories;

use App\Models\Category;
use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;

class EloquentPropertyRepository implements PropertyRepositoryInterface
{
    public function getBrandProductsProperties(int $brandId): Collection|array
    {
        return Property::filterByBrand($brandId)->isInFilter()->get();
    }

    public function getPropertiesByCategory(Category $category): Collection|array
    {
       return  Property::filtersProperties($category)->isInFilter()->isActive()->get();
    }

    public function getPropertiesByProductIdArr($productIdArr): Collection|array
    {
        return Property::filterByProductIdArr($productIdArr)->isInFilter()->get();
    }
}
