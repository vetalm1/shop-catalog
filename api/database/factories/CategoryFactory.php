<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = 'Category '.fake()->numberBetween(1, 1000);

        return [
            'sync_uuid' => fake()->uuid(),
            'name' => $name,
            'slug' => Str::slug($name),
            'title' => fake()->words(2, true),
            'description' => fake()->words(20, true),
            'hidden_description' => fake()->words(100, true),
            'card_short_description' => fake()->words(5, true),
            'is_active' => true,
            'order_column' => 0,
        ];
    }
}
