<?php

namespace App\Services\Brand;

use App\Http\Resources\Catalog\FilterResource;
use App\Models\Brand;
use App\Models\Category;
use App\Services\Brand\Repositories\BrandRepositoryInterface;
use App\Services\Category\Repositories\CategoryRepositoryInterface;
use App\Services\Product\Repositories\ProductFiltersRepositoryInterface;
use App\Services\Product\Repositories\ProductRepositoryInterface;
use App\Services\Property\Repositories\PropertyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandService
{
    public function __construct(
        readonly private BrandRepositoryInterface $brandRepository,
        readonly private CategoryRepositoryInterface $categoryRepository,
        readonly private ProductRepositoryInterface $productRepository,
        readonly private PropertyRepositoryInterface $propertyRepository,
        readonly private ProductFiltersRepositoryInterface $productFiltersRepository,
    ) {}

    public function getBrands($orderDirection, $brandQuery, $perPage): LengthAwarePaginator|array
    {
        return $this->brandRepository->brandListWithProductCount($orderDirection, $brandQuery, $perPage);
    }

    public function getBrand($brand): Brand
    {
        return $this->brandRepository->getBrandBySlugWithProductCount($brand);
    }

    public function getCategory($categorySlug): ?Category
    {
        return $categorySlug
            ? $this->categoryRepository->getCategoryBySlug($categorySlug)
            : null;
    }

    public function getCategories($request): Collection|array
    {
        $productIdArr = $this->productRepository
            ->getProducts(null, $request, null)
            ->pluck('id')
            ->toArray();

        return $this->categoryRepository->getCategoryListByProductIdArr($productIdArr);
    }

    public function getFilters($brand): array
    {
        $priceMin = $this->productFiltersRepository->getBrandProductsMinPrice($brand->id);
        $priceMax = $this->productFiltersRepository->getBrandProductsMaxPrice($brand->id);
        $properties = $this->propertyRepository->getBrandProductsProperties($brand->if);

        return [
            'prices' => ['min' => $priceMin, 'max' => $priceMax],
            'properties' => FilterResource::collection($properties),
        ];
    }
}
