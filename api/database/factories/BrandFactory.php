<?php

namespace Database\Factories;

use App\Models\Brand;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        $name = 'Бренд-'.fake()->numberBetween(1, 1000);

        return [
            'sync_uuid' => fake()->uuid(),
            'name' => $name,
            'slug' => Str::slug($name),
            'title' => fake()->words(2, true),
            'description' => fake()->words(5, true),
            'is_active' => true,
            'show_on_main' => true,
        ];
    }
}
