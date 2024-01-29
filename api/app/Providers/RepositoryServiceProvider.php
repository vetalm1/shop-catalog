<?php

namespace App\Providers;

use App\Services\Repositories\RepositoryInterface;

use App\Services\Brand\Repositories\BrandRepositoryInterface;
use App\Services\Brand\Repositories\EloquentBrandRepository;

use App\Services\Category\Repositories\CategoryRepositoryInterface;
use App\Services\Category\Repositories\EloquentCategoryRepository;

use App\Services\Product\Repositories\EloquentProductRepository;
use App\Services\Product\Repositories\ProductRepositoryInterface;

use App\Services\Product\Repositories\EloquentProductFiltersRepository;
use App\Services\Product\Repositories\ProductFiltersRepositoryInterface;

use App\Services\Property\Repositories\PropertyRepositoryInterface;
use App\Services\Property\Repositories\EloquentPropertyRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            RepositoryInterface::class,
            \App\Services\Repositories\EloquentRepository::class
        );
        $this->app->bind(
            BrandRepositoryInterface::class,
            EloquentBrandRepository::class
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            EloquentCategoryRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            EloquentProductRepository::class
        );
        $this->app->bind(
            ProductFiltersRepositoryInterface::class,
            EloquentProductFiltersRepository::class
        );
        $this->app->bind(
            PropertyRepositoryInterface::class,
            EloquentPropertyRepository::class
        );
    }

    public function boot()
    {
        //
    }
}
