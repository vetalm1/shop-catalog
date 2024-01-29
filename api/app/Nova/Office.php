<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Office extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\Office::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'type', 'title'];

    public static $group = 'Каталог';

    public static function label()
    {
        return 'Офисы';
    }

    public static function singularLabel()
    {
        return 'Офис';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'title')->sortable(),
            Text::make('Название (кратк.)', 'short_title')->sortable(),
            Markdown::make('Описание', 'text')->hideFromIndex()->sortable(),
            Text::make('Подпись адреса', 'address_title')->hideFromIndex()->sortable(),
            Text::make('Адрес', 'address')->hideFromIndex()->sortable(),
            KeyValue::make('Адрес (email)', 'emails')->rules('json')
                ->keyLabel('Заголовок')
                ->valueLabel('email')
                ->actionText('добавить email'),
            Text::make('Телефон', 'phone')->sortable(),
            Trix::make('Режим работы', 'opening_hours')->sortable(),
            Text::make('Широта (lat)', 'lat')->sortable(),
            Text::make('Долгота (lon)', 'lon')->sortable(),

            Images::make('Галерея изображений (для модального окна)', 'image-gallery')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                })->hideFromIndex(),

            Images::make('Изображение для карточки', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                })->hideFromIndex(),

            Images::make('Изображение флага страны', 'flag_image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                })->hideFromIndex(),

            Boolean::make('Опубликовано', 'is_active')
                ->sortable(),
        ];
    }
}
