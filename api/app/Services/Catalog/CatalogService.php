<?php

namespace App\Services\Catalog;

use App\Models\Category;
use App\Services\Brand\Repositories\BrandRepositoryInterface;
use App\Services\Category\Handlers\HideNotActiveCategories;
use App\Services\Category\Repositories\CategoryRepositoryInterface;
use App\Services\Product\Repositories\ProductFiltersRepositoryInterface;
use App\Services\Product\Repositories\ProductRepositoryInterface;
use App\Services\Property\Repositories\PropertyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Kalnoy\Nestedset\Collection as NestedSetCollection;

class CatalogService
{
    public function __construct(
       readonly private CategoryRepositoryInterface $categoryRepository,
       readonly private ProductRepositoryInterface $productRepository,
       readonly private BrandRepositoryInterface $brandRepository,
       readonly private PropertyRepositoryInterface $propertyRepository,
       readonly private ProductFiltersRepositoryInterface $productFiltersRepository,
       readonly private HideNotActiveCategories $hideNotActiveCategories,
    ) {}

    const PRODUCTS_PER_PAGE_COUNT_DEFAULT = 10;

    public function getCategoryBySlug($slug): Category
    {
        return $this->categoryRepository->getCategoryBySlug($slug);
    }

    public function getCategoryTree(): NestedSetCollection
    {
        $categoryTree = $this->categoryRepository->getCategoryTreeWithProductCount();
        $this->hideNotActiveCategories->handle($categoryTree);

        return $categoryTree;
    }

    public function gerBreadcrumbsByProductSlug(string|null $productSlug): NestedSetCollection
    {
        $category = $this->categoryRepository->getFirstCategoryByProductSlug($productSlug);

        return $this->gerBreadcrumbs($category);
    }

    public function gerBreadcrumbs(Category $category): NestedSetCollection
    {
        return $this->categoryRepository->getCategoryAncestorsAndSelf($category);
    }

    public function getPopularCategories(): SupportCollection
    {
        return $this->categoryRepository->getPopularCategories()
            ->map(function ($item) {return $item->category;});
    }

    public function getProducts($category, $request): LengthAwarePaginator|array
    {
        $perPage = $request->input('per_page', self::PRODUCTS_PER_PAGE_COUNT_DEFAULT);

        return $this->productRepository->getProducts($category->id, $request, $perPage);
    }

    public function getFilters($category): array
    {
        $category = $this->categoryRepository->getCategoryBySlug($category);

        $brands = $this->brandRepository->getBrandsByCategory($category);

        $priceMax = $this->productFiltersRepository->getCategoryProductsMaxPrice($category->id);
        $priceMin = $this->productFiltersRepository->getCategoryProductsMinPrice($category->id);

        $properties = $this->propertyRepository->getPropertiesByCategory($category);

        return [
            'brands' => $brands,
            'prices' => ['min' => $priceMin, 'max' => $priceMax],
            'properties' => $properties,
        ];
    }

    public function getFiltersByFoundProducts($query): array
    {
        $productIdArr = $this->productRepository
            ->getSearchProducts(null, $query, null)
            ->pluck('id')->toArray();

        $priceMin = $this->productFiltersRepository->getProductIdArrMinPrice($productIdArr);
        $priceMax = $this->productFiltersRepository->getProductIdArrMaxPrice($productIdArr);

        $brands = $this->brandRepository->getBrandsByProductIdArr($productIdArr);

        $properties = $this->propertyRepository->getPropertiesByProductIdArr($productIdArr);

        return [
            'brands' => $brands,
            'prices' => ['min' => $priceMin, 'max' => $priceMax],
            'properties' => $properties,
        ];
    }
}
