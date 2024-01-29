<?php

namespace App\Nova;

use App\Support\Enums\SliderType;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Slider extends Resource
{
    public static $model = \App\Models\Slider::class;
    public static $title = 'name';
    public static $search = ['name', 'type'];

    public static $group = 'Main Page';

    public static function label()
    {
        return 'Слайдеры (банеры)';
    }

    public static function singularLabel()
    {
        return 'Слайдер (банер)';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Наименование', 'name')
                ->sortable()->rules('max:255'),

            Select::make('Тип(техн. имя)', 'type')
                //->options(collect(SliderType::cases())->pluck('name', 'value'))
                ->options(SliderType::getSelectData())
                ->rules('required', 'max:255')
                ->displayUsingLabels()->hideFromIndex()->readonly(),

            Text::make('Заголовок', 'title')
                ->sortable()->rules('max:255'),

            Text::make('Под заголовок', 'sub_title'),

            HasMany::make('Слайды', 'slides', 'App\Nova\Slide'),
        ];
    }
}
