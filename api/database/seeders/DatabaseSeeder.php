<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\PopularCategory;
use App\Models\Product;
use App\Models\Property;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        Category::factory()->times(3)->create();
        Category::fixTree();
        Category::factory()->times(2)->create(['parent_id' => 1]);
        Category::factory()->times(2)->create(['parent_id' => 2]);
        Category::factory()->times(2)->create(['parent_id' => 3]);
        Category::factory()->times(2)->create(['parent_id' => 4]);
        Category::factory()->times(2)->create(['parent_id' => 5]);
        Category::factory()->times(1)->create();
        Category::fixTree();

        PopularCategory::factory()->times(3)->create();
        Brand::factory()->times(14)->create();
        Property::factory()->times(20)->create();
        Product::factory()->times(100)->create();
        Warehouse::factory()->times(2)->create();

        $this->call([
            ProductRelationSeeder::class,
        ]);
    }
}
