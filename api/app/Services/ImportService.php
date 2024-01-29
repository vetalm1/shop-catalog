<?php

namespace App\Services;

use App\Jobs\SyncImagesJob;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\SyncData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportService
{
    public Collection $brandsMap;
    public Collection $propertiesMap;

    public function syncCatalog(): void
    {
        $catalogArray = $this->getData('import0_1.json');

        $products = $catalogArray['Товары'];
        $properties = $catalogArray['Свойства'];
        $categories = $catalogArray['ВидыНоменклатуры'];

        /**Categories*/
        DB::transaction(function () use ($categories) {

            $this->parseCategories($categories, 0, null);

            Category::fixTree();
        });

        /**Properties*/
        DB::transaction(function () use ($properties) {

            foreach ($properties as $property) {

                $property = $property['Свойство'];

                Property::updateOrCreate(
                    ['sync_uuid' => $property['ИД']],
                    [
                        'name' => $property['Наименование'],
                        'is_active' => true
                    ]
                );
            }
        });

        $this->brandsMap = Brand::select('id', 'sync_uuid')->get();
        $this->propertiesMap = Property::select('id', 'sync_uuid')->get();

        /**Products*/
        DB::transaction(function () use ($products, $properties) {

            foreach ($products as $product) {

                $product = $product['Товар'];

                $brandId = $this->getBrandIdByUuid($product);

                $productData = [
                    'sync_uuid' => $product['Ид'],
                    'art' => $product['Артикул'],
                    'name' => $product['Наименование'],
                    'description' => $product['Описание'],
                    'brand_id' => $brandId,
                    'is_active' => true,
                ];

                Product::updateOrCreate(['sync_uuid' => $product['Ид']], $productData);
            }
        });
    }

    public function syncStocks(): void
    {
        SyncData::create(['type' => 'Start sync stocks and prices']);

        $offers = $this->getData('offers0_1.json');

        /* any code */

    }

    public function syncStockChanges(): void /*пока не работает*/
    {
        $offers = $this->getData('offers_changes.json');

        foreach ($offers as $offer) {

            $offer = $offer['Предложение'];

            /* any code*/
        }
    }

    private function parseCategories($categories, $depth, $parentId): void
    {
        $depth++;
        foreach ($categories as $category) {

            $category = $category['ВидНоменклатуры'];

            $categoryData = [
                /* any code*/
            ];

            $newCategory = Category::updateOrCreate(
                ['sync_uuid' => $category['Ид']],
                $categoryData
            );

            if (isset($category['ВидыНом'])) {
                $this->parseCategories($category['ВидыНом'], $depth, $newCategory->id);
            }
        }
    }

    private function getBrandIdByUuid($product)
    {
        if (!isset($product['Марка'])) return null;

        $uuid = $product['Марка']['Ид'];

        $brand = $this->brandsMap->where('sync_uuid', $uuid)->first();

        return $brand?->id;
    }

    private function getData($fileName)
    {
        $file = Storage::disk('storage')->get('sync/' . $fileName);
        return json_decode($file, true);
    }

}
