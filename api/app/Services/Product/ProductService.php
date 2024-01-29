<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductAddition;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function getProductBySlug($slug): Product
    {
        return Product::whereSlug($slug)->firstOrFail();
    }

    public function getSimilarProducts($product)
    {
        return $product->similarProducts
            ->map(function ($item) {
                return $item->relatedProduct;
            });
    }

    public function getProductAddition(): Collection|array
    {
        return ProductAddition::isActive()->orderBy('order_column')->get();
    }
}
