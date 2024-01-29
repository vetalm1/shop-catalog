<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $name = 'Property '.fake()->numberBetween(1, 1000);
        $propertyGroups = PropertyGroup::get();

        return [
            'sync_uuid' => fake()->uuid(),
            'name' => $name,
            'property_group_id' => $propertyGroups->random()->id,
            'slug' => Str::slug($name),
            'is_active' => true,
            'is_in_filter' => (bool)rand(0,1),
            'is_main' => (bool)rand(0,1),
        ];
    }
}
