<?php

namespace App\Services\Brand\Repositories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class EloquentBrandRepository implements BrandRepositoryInterface
{

    public function find(int $id): Brand
    {
        return Brand::find($id);
    }

    public function brandListWithProductCount($orderDirection, $brandQuery, $perPage): LengthAwarePaginator|array
    {
        return Brand::withCount('products')
            ->sort($orderDirection)
            ->getBrandByQuery($brandQuery)
            ->isActive()
            ->paginate($perPage);
    }

    public function getBrandBySlugWithProductCount(string $slug)
    {
        return Brand::withCount('products')->whereSlug($slug)->isActive()->firstOrFail();
    }

    public function getBrandsByCategory($category): Collection|array
    {
        return Brand::filterByCategory($category)->get();
    }

    public function getBrandsByProductIdArr($productIdArr): Collection|array
    {
        return Brand::filterByProductIdArr($productIdArr)->get();
    }
}
