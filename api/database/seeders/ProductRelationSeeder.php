<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserData;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::get();

        $categories = Category::whereNotNull('parent_id')->get();
        $relations = [];
        foreach ($products as $product) {
            $relations[] = [
                'product_id' => $product->id,
                'category_id' => $categories->random()->id
            ];
        }
        DB::table('category_product')->insert($relations);

        $items = Property::get();
        $relations = [];
        foreach ($products as $product) {
            for ($i = 0; $i < 10; $i++) {
                $relations[] = [
                    'product_id' => $product->id,
                    'property_id' => $items->random()->id,
                    'value' => fake()->numberBetween(10, 20)
                ];
            }
        }
        DB::table('property_values')->insert($relations);

        $relations = [];
        foreach ($products as $product) {
            $relations[] = [
                'product_id' => $product->id,
                'related_product_id' => $products->random()->id,
            ];
        }
        DB::table('similar_products')->insert($relations);
    }
}
