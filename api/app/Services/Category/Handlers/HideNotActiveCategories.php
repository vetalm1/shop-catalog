<?php

namespace App\Services\Category\Handlers;

class HideNotActiveCategories
{
    public function handle($categoryTree): void
    {
        foreach ($categoryTree as $key => $category) {
            if (!$category->is_active) {
                $categoryTree->forget($key);
            }
            if (!$category->children->isEmpty()) {
                $this->handle($category->children);
            }
        }
    }
}
