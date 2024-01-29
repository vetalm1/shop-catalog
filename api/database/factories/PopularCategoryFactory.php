<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\PopularCategory;

use Illuminate\Database\Eloquent\Factories\Factory;

class PopularCategoryFactory extends Factory
{
    protected $model = PopularCategory::class;

    public function definition(): array
    {
        $category = Category::whereNotNull('parent_id')->get()->random();

        return [
            'title' => $category->name,
            'category_id' => $category->id,
        ];
    }
}
