<?php

namespace App\Services\Product\Repositories;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentProductRepository implements ProductRepositoryInterface
{
    const PRODUCTS_PER_PAGE_COUNT_DEFAULT = 10;

    public function getProducts(
        int|null $categoryId,
        string|null $request,
        $perPage = self::PRODUCTS_PER_PAGE_COUNT_DEFAULT
    ): LengthAwarePaginator|array
    {
        return $this
            ->getProductsQuery($categoryId, $request, $perPage);
    }

    public function getSearchProducts(
        int|null $categoryId,
        string|null $searchQuery,
        $request,
        $perPage = self::PRODUCTS_PER_PAGE_COUNT_DEFAULT
    ): LengthAwarePaginator|array
    {
        return $this
            ->getProductsQuery($categoryId, $request, $perPage)
            ->simpleSearch($searchQuery);
    }

    private function getProductsQuery(int|null $categoryId, string|null $request, int $perPage)
    {
        return Product::query()
            ->filterByCategory($categoryId)
            ->filterByRequest($request)
            ->sort($request->input('sort_by'))
            ->isActive()
            ->positivePrice()
            ->orderBy('name')
            ->paginate($perPage);
    }
}
