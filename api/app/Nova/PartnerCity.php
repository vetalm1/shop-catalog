<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;


class PartnerCity extends Resource
{
    public static $model = \App\Models\PartnerCity::class;
    public static $title = 'city';
    public static $search = ['id', 'city', 'title', 'is_active'];

    public static $group = 'Главная';

    public static function label() {return 'Города партнеров';}

    public static function singularLabel() {return 'Город партнеров';}

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Город', 'city')->sortable(),
            Text::make('Заголовок', 'title')->sortable(),
            Markdown::make('Текст', 'text')->hideFromIndex()->sortable(),
            Heading::
                make('<a style="color: blue" href="/api/map-points" target="_blank">
                        * Определить координаты точки на карте (после нажатия будут скопированы в буфер)
                </a>')
                ->asHtml(),
            Text::make('Координаты точки на карте', 'coords')
                ->help('Горизонталь/вертикаль (в %)'),


            Boolean::make('Опубликовано', 'is_active')
                ->sortable(),
        ];
    }
}
