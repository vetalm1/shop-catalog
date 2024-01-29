<?php

namespace App\Services\Product\Repositories;

use App\Models\Product;

class EloquentProductFiltersRepository implements ProductFiltersRepositoryInterface
{
    public function getBrandProductsMinPrice(int $brandId): float|null
    {
        return Product::filterByBrand($brandId)->min('price');
    }

    public function getBrandProductsMaxPrice(int $brandId): float|null
    {
        return Product::filterByBrand($brandId)->max('price');
    }

    public function getCategoryProductsMinPrice($categoryId): float|null
    {
        return Product::filterByCategory($categoryId)->min('price');
    }

    public function getCategoryProductsMaxPrice($categoryId): float|null
    {
        return Product::filterByCategory($categoryId)->max('price');
    }

    public function getProductIdArrMaxPrice($productIdArr): float|null
    {
        return Product::filterByProductIdArr($productIdArr)->positivePrice()->max('price');
    }

    public function getProductIdArrMinPrice($productIdArr): float|null
    {
        return Product::filterByProductIdArr($productIdArr)->positivePrice()->min('price');
    }
}
