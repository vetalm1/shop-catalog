<?php

namespace App\Nova;

use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\NovaTranslatable\Translatable;

class SimilarProduct extends Resource
{
    public static $model = \App\Models\SimilarProduct::class;
    public static $title = 'name';
    public static $search = ['id', 'product_id'];

    public static $group = 'Catalog';

    public static $displayInNavigation = false;

    public static function label()
    {
        return 'Похожие товары';
    }

    public static function singularLabel()
    {
        return 'Похожий товар';
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make('Товар', 'product', 'App\Nova\Product')
                ->searchable(),

            BelongsTo::make('Товар аналог', 'relatedProduct', 'App\Nova\Product')
                ->searchable(),
        ];
    }

}
