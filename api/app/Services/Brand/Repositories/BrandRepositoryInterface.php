<?php


namespace App\Services\Brand\Repositories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

interface BrandRepositoryInterface
{
    public function find(int $id): Brand;

    public function brandListWithProductCount( string $orderDirection, string $brandQuery, int $perPage);

    public function getBrandBySlugWithProductCount(string $slug);

    public function getBrandsByCategory($category): Collection|array;

    public function getBrandsByProductIdArr($productIdArr): Collection|array;
}
