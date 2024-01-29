<?php

namespace App\Services\Category\Repositories;

use App\Models\Category;
use App\Models\PopularCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Kalnoy\Nestedset\Collection as NestedSetCollection;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function getCategoryBySlug(string|null $slug): Category
    {
        return Category::whereSlug($slug)->isActive()->firstOrFail();
    }

    public function getCategoryListByProductIdArr(array $productIdArr): Collection|array
    {
        return Category::whereHas('products', function ($query) use ($productIdArr) {
            return $query->whereIn('product_id', $productIdArr);
        })->get();
    }

    public function getCategoryTreeWithProductCount(): NestedSetCollection
    {
        return Category::withCount('products')->get()->toTree();
    }

    public function getFirstCategoryByProductSlug(string|null$productSlug): Category
    {
        return Category::whereHasProductSlug($productSlug)->isActive()->firstOrFail();
    }

    public function getCategoryAncestorsAndSelf(int $category_Id): NestedSetCollection
    {
        return Category::ancestorsAndSelf($category_Id)->sortBy('_lft');
    }

    public function getPopularCategories(): SupportCollection /* пока здесь */
    {
        return PopularCategory::sort()->get();
    }
}
