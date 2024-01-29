<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class ProductAddition extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\ProductAddition::class;
    public static $title = 'name';
    public static $search = ['id', 'title', 'is_active'];

    public static $group = 'Каталог';

    public static function label()
    {
        return 'Дополнительные табы, для страницы товара';
    }

    public static function singularLabel()
    {
        return 'Таб';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Название таба', 'title')
                ->sortable()->rules('max:255'),
            Text::make('Заголовок для блока с изображениями', 'images_title')
                ->sortable()->rules('max:255'),

            Markdown::make('Описание короткое', 'description')
                ->rules('nullable')
                ->hideFromIndex(),
            Markdown::make('Описание', 'other_description')
                ->rules('nullable')
                ->hideFromIndex(),

            Images::make('Галерея изображений', 'image-gallery')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                })->hideFromIndex(),

            Boolean::make('Опубликован', 'is_active')
                ->sortable(),
        ];
    }
}
