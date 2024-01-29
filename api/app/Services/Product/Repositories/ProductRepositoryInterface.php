<?php

namespace App\Services\Product\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getProducts(int|null $categoryId, string|null $request, $perPage): LengthAwarePaginator|array;

    public function getSearchProducts(
        int|null $categoryId,
        string|null $searchQuery,
        $request,
        $perPage
    ): LengthAwarePaginator|array;
}
