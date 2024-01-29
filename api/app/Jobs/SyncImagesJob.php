<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\SyncData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SyncImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function handle()
    {
        foreach ($this->products as $product) {

            $newProduct = Product::where('sync_uuid', $product['Ид'])->first();

            foreach ($product['images'] as $image) {

                $imageResponse = $this->getImage($image);

                if ($imageResponse) {

                    if ($this->checkImageIsImported($newProduct, 'image', $imageResponse)) continue;

                    $newProduct->clearMediaCollection('image');

                    $newProduct
                        ->addMediaFromString($imageResponse)
                        ->usingFileName(Str::afterLast($image, '/'))
                        ->withCustomProperties(['image_hash' => Hash::make($imageResponse)])
                        ->toMediaCollection('image');
                }
            }
        }
    }


    private function checkImageIsImported($product, $collectionName, $imageResponse): bool
    {
        $imageHash = $product->getFirstMedia($collectionName)?->getCustomProperty('image_hash');

        return Hash::check($imageResponse, $imageHash);
    }

    private function getImage($url): ?string
    {
        try {
            $response = Http::get($url);

            $response->status() === 200
                ? $imageResponse = $response->body()
                : $imageResponse = null ;

        } catch (Exception $e) {
            $imageResponse = null;
        }

        return $imageResponse;
    }
}
