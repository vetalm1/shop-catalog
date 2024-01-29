<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Resources\Catalog\FilterResource;
use App\Http\Resources\Category\CategoryBranchResource;
use App\Http\Resources\Category\CategoryBreadcrumbsResource;
use App\Http\Resources\Category\CategoryCardResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryTreeResource;
use App\Http\Resources\Category\PopularCategoryResource;
use App\Http\Resources\Components\IdNameSlugResource;
use App\Http\Resources\MainPage\PageContentResource;
use App\Http\Resources\Product\ProductCardResource;
use App\Services\Catalog\CatalogService;
use App\Services\PageContent\PageContentService;
use App\Services\Sections\SectionsService;
use App\Support\Enums\SectionContentTechNameType as TechNameType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CatalogController extends Controller
{
    const SEO_SECTION = 'catalog';

    public function __construct(
        private readonly CatalogService $catalogService,
        private readonly PageContentService $pageContent,
        private readonly SectionsService $sectionsService
    ) {}

    public function lvlFirst()
    {
        $categoryTree = $this->catalogService->getCategoryTree();

        $popularCategories = $this->catalogService->getPopularCategories();

        $formBlockText = $this->pageContent
            ->getPageContent(TechNameType::CatalogPageBottomGetBackCall->value, self::SEO_SECTION);

        $section = $this->sectionsService->getSeoSection(self::SEO_SECTION);

        return response()->json([
            'category_tree' => CategoryTreeResource::collection($categoryTree),
            'popular_categories' => PopularCategoryResource::collection($popularCategories),
            'main_categories' => CategoryCardResource::collection($categoryTree),
            'form_block_text' => PageContentResource::collection($formBlockText),

            'seo_title' => $section->seo_title,
            'seo_description' => $section->seo_description
        ]);
    }

    public function getPrice($slug = null)
    {
        $name = 'price';

        return Excel::download(new ProductsExport($slug), $name . '.xlsx');
    }

    public function lvlSecond(Request $request, $category)
    {
        $category = $this->catalogService->getCategoryBySlug($category);

        $breadcrumbs = $this->catalogService->gerBreadcrumbs($category);

        $siblings = $category->siblingsAndSelf()->get();

        $categoryTree = $this->catalogService->getCategoryTree();

        $popularCategories = $this->catalogService->getPopularCategories();

        $products = $this->catalogService->getProducts($category, $request);

        return response()->json([
            'category' => new CategoryResource($category),
            'breadcrumbs' => CategoryBreadcrumbsResource::collection($breadcrumbs),
            'siblings' => CategoryBranchResource::collection($siblings),
            'category_tree' => CategoryTreeResource::collection($categoryTree),
            'popular_categories' => PopularCategoryResource::collection($popularCategories),
            'products' => ProductCardResource::collection($products)->response()->getData(true),
        ]);
    }

    public function filters($category)
    {
        $filters = $this->catalogService->getFilters($category);

        return response()->json([
            'brands' => IdNameSlugResource::collection($filters['brands']),
            'prices' => $filters['prices'],
            'properties' => FilterResource::collection($filters['properties']),
        ]);
    }
}
