<?php

namespace App\Services\Product\Repositories;

interface ProductFiltersRepositoryInterface
{
    public function getBrandProductsMinPrice(int $brandId): float|null;

    public function getBrandProductsMaxPrice(int $brandId): float|null;

    public function getCategoryProductsMinPrice($categoryId): float|null;

    public function getCategoryProductsMaxPrice($categoryId): float|null;

    public function getProductIdArrMaxPrice($productIdArr): float|null;

    public function getProductIdArrMinPrice($productIdArr): float|null;
}
