<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Slide extends Resource
{
    public static $model = \App\Models\Slide::class;
    public static $title = 'title';
    public static $search = ['title', 'description', 'button_text'];

    public static $group = 'Main Page';

    public static $displayInNavigation = false;

    public static function label()
    {
        return 'Слайды (банеры)';
    }

    public static function singularLabel()
    {
        return 'Слайд (банер)';
    }


    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Заголовок', 'title')->sortable()->rules('max:255'),
            Textarea::make('Описание', 'description')->sortable(),

            Text::make('Текст кнопки', 'button_text')->hideFromIndex()->rules('max:255'),
            Text::make('Ссылка кнопки', 'button_link')->hideFromIndex()->rules('max:255'),

            Text::make('Цвет фона кнопки', 'button_background_color')->hideFromIndex()->rules('max:255'),
            Text::make('Цвет текста кнопки', 'button_text_color')->hideFromIndex()->rules('max:255'),
            Text::make('Цвет рамки кнопки', 'button_frame_color')->hideFromIndex()->rules('max:255'),

            BelongsTo::make('Слайдер', 'slider', 'App\Nova\Slider')->searchable(),

            Images::make('Изображение', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function($originalFilename, $extension, $model){
                    return md5($originalFilename) . '.' . $extension;
                }),

            Boolean::make('Опубликован', 'is_active')->sortable(),
        ];
    }

    public static function relatableCategories(NovaRequest $request, $query)
    {
        return $query->where('parent_id', null);
    }
}

