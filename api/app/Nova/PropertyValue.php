<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class PropertyValue extends Resource
{
    public static $model = \App\Models\PropertyValue::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'slug', 'sync_uuid'];

    public static $group = 'Catalog';

    public static $displayInNavigation = false;

    public static function label()
    {
        return 'Значения свойств';
    }

    public static function singularLabel()
    {
        return 'Значение свойства';
    }

    public function fields(NovaRequest $request)
    {
        return [

            BelongsTo::make('Товар', 'product', Product::class)
                ->searchable(),

            BelongsTo::make('Свойство', 'property', Property::class)
                ->searchable(),

            Text::make('Значение свойства', 'value')
                ->sortable()
                ->rules('max:255'),

        ];
    }
}
