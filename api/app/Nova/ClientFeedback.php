<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class ClientFeedback extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\ClientFeedback::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'type', 'title'];

    public static $group = 'Каталог';

    public static function label()
    {
        return 'Отзывы клиентов';
    }

    public static function singularLabel()
    {
        return 'Отзыв';
    }

        public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name')->sortable(),
            Text::make('Должность', 'position')->sortable(),
            Text::make('Название компании', 'company_name')->sortable(),
            Text::make('Подзаголовок компании', 'company_title')->sortable(),

            Trix::make('Короткий текст', 'short_text')->sortable(),
            Trix::make('Текст', 'text')->sortable(),

            Images::make('Изображение', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                }),

            Boolean::make('Опубликовано', 'is_active')
                ->sortable(),
        ];
    }
}
