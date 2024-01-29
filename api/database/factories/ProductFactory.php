<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = 'Product '.fake()->numberBetween(1, 1000);

        return [
            'sync_uuid' => fake()->uuid(),
            'art' => fake()->numberBetween(999000,999999),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->realText,
            'hidden_description' => fake()->words(50, true),
            'price' => fake()->numberBetween(1000,10000),
            'balance' => fake()->numberBetween(1,50),
            'brand_id' => Brand::all()->random()->id,
            'delivery_properties' => ['width' => 1, 'height' => 10, 'length' => 100, 'weight' => 50],
            'is_active' => true,
        ];
    }
}
