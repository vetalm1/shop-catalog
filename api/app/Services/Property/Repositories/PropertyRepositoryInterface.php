<?php

namespace App\Services\Property\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface PropertyRepositoryInterface
{
    public function getBrandProductsProperties(int $brandId): Collection|array;

    public function getPropertiesByCategory(Category $category): Collection|array;

    public function getPropertiesByProductIdArr($productIdArr): Collection|array;
}
