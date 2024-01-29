<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Advantage extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\Advantage::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'type', 'title'];

    public static $group = 'Каталог';

    public static function label()
    {
        return 'Преимущества';
    }

    public static function singularLabel()
    {
        return 'Преимущество';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name')->sortable()->hideFromIndex(),
            Text::make('Секция', 'type')->sortable(),
            Text::make('Заголовок', 'title')->sortable(),
            Text::make('Подзаголовок', 'sub_title')->sortable(),
            Trix::make('Текст', 'text')->sortable(),

            Images::make('Изображение (лого)', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                }),

            Images::make('Изображение (фото)', 'photo-image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                })
                ->hideFromIndex(),

            Boolean::make('Опубликовано', 'is_active')
                ->sortable(),
        ];
    }
}
