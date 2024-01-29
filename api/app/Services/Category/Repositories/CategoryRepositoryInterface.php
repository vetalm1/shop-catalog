<?php


namespace App\Services\Category\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Kalnoy\Nestedset\Collection as NestedSetCollection;

interface CategoryRepositoryInterface
{
    public function getCategoryBySlug(string $slug): Category;

    public function getCategoryListByProductIdArr(array $productIdArr): Collection|array;

    public function getCategoryTreeWithProductCount(): NestedSetCollection;

    public function getFirstCategoryByProductSlug(string|null$productSlug): Category;

    public function getCategoryAncestorsAndSelf(int $category_Id): NestedSetCollection;

    public function getPopularCategories(): SupportCollection; /* пока здесь */
}
