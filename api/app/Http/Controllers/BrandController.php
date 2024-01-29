<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\BrandsRequest;
use App\Http\Resources\Catalog\BrandCardResource;
use App\Http\Resources\Catalog\BrandResource;
use App\Http\Resources\Catalog\FilterResource;
use App\Http\Resources\Components\IdNameSlugResource;
use App\Http\Resources\Product\ProductCardResource;
use App\Services\Brand\BrandService;
use App\Services\Catalog\CatalogService;
use App\Services\Sections\SectionsService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    const BRANDS_PER_PAGE = 12;
    const SEO_SECTION = 'brand';

    public function __construct(
        private readonly CatalogService $catalogService,
        private readonly BrandService   $brandService,
        readonly private SectionsService $sectionsService
    ) {}

    public function getBrands(BrandsRequest $request)
    {
        $orderDirection = $request->get('sort');
        $brandQuery = $request->get('brand_q');

        $brands = $this->brandService->getBrands($orderDirection, $brandQuery, self::BRANDS_PER_PAGE);

        $seoSection = $this->sectionsService->getSeoSection(self::SEO_SECTION);

        return response()->json([
            'brands' => BrandCardResource::collection($brands)->response()->getData(true),
            'seo_title' => $seoSection?->title,
            'seo_description' => $seoSection?->description,
        ]);
    }

    public function getBrand($brand, Request $request)
    {
        $brand = $this->brandService->getBrand($brand);
        $request->merge(['brands' => [$brand->slug]]);

        $category = $this->brandService->getCategory($request);

        $products = $this->catalogService->getProducts($category, $request);

        $categories = $this->brandService->getCategories($request);

        $filters = $this->brandService->getFilters($brand);

        return response()->json([
            'filters' => [
                'prices' => $filters['prices'],
                'properties' => FilterResource::collection($filters['properties']),
            ],
            'categories' => IdNameSlugResource::collection($categories),
            'brand' => new BrandResource($brand),
            'products' => ProductCardResource::collection($products)->response()->getData(true),
        ]);
    }
}
