<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\MainPagePopularCategory;
use App\Models\PopularCategory;

use Illuminate\Database\Eloquent\Factories\Factory;

class MainPagePopularCategoryFactory extends Factory
{
    protected $model = MainPagePopularCategory::class;

    public function definition(): array
    {
        $category = Category::whereNotNull('parent_id')->get()->random();

        return [
            'title' => $category->name,
            'category_id' => $category->id,
        ];
    }
}
