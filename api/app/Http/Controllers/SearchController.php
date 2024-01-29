<?php

namespace App\Http\Controllers;

use App\Http\Resources\Catalog\BrandResource;
use App\Http\Resources\Catalog\FilterResource;
use App\Http\Resources\Category\CategoryCardResource;
use App\Http\Resources\MainPage\PageContentResource;
use App\Http\Resources\Product\ProductCardResource;
use App\Services\Catalog\CatalogService;
use App\Services\Category\Repositories\CategoryRepositoryInterface;
use App\Services\PageContent\PageContentService;
use App\Services\Product\Repositories\ProductRepositoryInterface;
use App\Support\Enums\SectionContentTechNameType as TechNameType;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    const PAGE_NAME = 'search';

    public function __construct(
        private readonly CatalogService              $catalogService,
        private readonly PageContentService          $pageContent,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly ProductRepositoryInterface $productRepository
    ) {
    }

    public function search(Request $request)
    {
        $searchQuery = $request->get('q');
        $categorySlug = $request->get('category');

        $category = $request->has('category')
            ? $this->categoryRepository->getCategoryBySlug($categorySlug)
            : null;

        $foundProductsUseFilter = $this->productRepository
            ->getSearchProducts($category, $searchQuery, $request); /* simpleSearch() */

        $filters = $this->catalogService->getFiltersByFoundProducts($searchQuery);

        $popularCategories = $this->categoryRepository->getPopularCategories();

        $formBlockTextData = $this->pageContent
            ->getPageContent(TechNameType::SearchPageProductOrderForm->value, self::PAGE_NAME);

        return response()->json([
            'filters' => [
                'brands' => BrandResource::collection($filters['brands']),
                'prices' => ['min' => $filters['priceMin'], 'max' => $filters['priceMax']],
                'properties' => FilterResource::collection($filters['properties']),
            ],
            'popular_categories' => CategoryCardResource::collection($popularCategories),
            'products' => ProductCardResource::collection($foundProductsUseFilter)->response()->getData(true),
            'form_text_data' => PageContentResource::collection($formBlockTextData),
        ]);
    }
}
