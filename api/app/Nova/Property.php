<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Property extends Resource
{
    public static $model = \App\Models\Property::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'slug', 'sync_uuid'];

    public static $group = 'Каталог';

    public static function label()
    {
        return 'Характеристики';
    }

    public static function singularLabel()
    {
        return 'Характеристика';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name')->sortable(),
            Textarea::make('Доп. информация о свойстве', 'more_info')->rows(2),
            Text::make('Slug', 'slug')->hideFromIndex(),
            Text::make('1C UUID', 'sync_uuid')->hideFromIndex(),

            BelongsTo::make('Группа свойств', 'propertyGroup', PropertyGroup::class)
                ->searchable()
                ->nullable(),

            Boolean::make('Опубликовано', 'is_active')->sortable(),
            Boolean::make('Главное (отображать в блоке с изображением)', 'is_main')->hideFromIndex(),

            Boolean::make('filter', 'is_in_filter')
                ->sortable(),
        ];
    }
}
