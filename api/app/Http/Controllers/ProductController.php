<?php

namespace App\Http\Controllers;

use App\Http\Resources\Catalog\ProductAdditionResource;
use App\Http\Resources\Components\IdNameSlugResource;
use App\Http\Resources\Product\ProductCardResource;
use App\Http\Resources\Product\ProductResource;
use App\Services\Catalog\CatalogService;
use App\Services\Contact\ContactService;
use App\Services\Product\ProductService;
use App\Support\Enums\ContactPlaceType;
use App\Support\Enums\ContactsType;

class ProductController extends Controller
{
    public function __construct(
        private readonly CatalogService $catalogService,
        private readonly ProductService $productService,
        private readonly ContactService $contactService
    ) {}

    public function getProduct($slug)
    {
        $breadcrumbs = $this->catalogService->gerBreadcrumbsByProductSlug($slug);

        $product = $this->productService->getProductBySlug($slug);

        $similarProducts = $this->productService->getSimilarProducts($product);

        $productAdditions = $this->productService->getProductAddition();

        $helpBlockPhone = $this->contactService
            ->getContact(ContactPlaceType::ProductPage->value, ContactsType::PHONE->value);

        $helpBlockEmail = $this->contactService
            ->getContact(ContactPlaceType::ProductPage->value, ContactsType::EMAIL->value);

        return response()->json([
            'breadcrumbs' => IdNameSlugResource::collection($breadcrumbs),
            'product' => new ProductResource($product),
            'product_additions' => ProductAdditionResource::collection($productAdditions),
            'similar_products' => ProductCardResource::collection($similarProducts),
            'help_block' => [
                'phone' => $helpBlockPhone->value,
                'email' => $helpBlockEmail->value,
            ]
        ]);
    }
}
