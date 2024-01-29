<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Brand extends Resource
{
    public static $model = \App\Models\Brand::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'slug', 'sync_uuid'];

    public static $group = 'Каталог';

    public static function label()
    {
        return 'Бренды';
    }

    public static function singularLabel()
    {
        return 'Бренд';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('1C UUID', 'sync_uuid')
                ->rules('required', 'max:255')
                ->hideFromIndex(),

            Text::make('Название', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug', 'slug')
                ->from('name')
                ->rules('nullable', 'max:255')
                ->hideFromIndex(),

            Textarea::make('Описание', 'description')
                ->rules('nullable')
                ->hideFromIndex(),

            Images::make('Изображение', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                }),
            Images::make('Изображение при наведении (таблица на главной)', 'hover_image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                }),

            Boolean::make('Показывать на главной', 'show_on_main')
                ->hideFromIndex(),

            Boolean::make('Опубликован', 'is_active')
                ->sortable(),

            new Panel('SEO', $this->seoFields()),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            new Actions\ActivateAction(),
            new Actions\DeactivateAction()
        ];
    }

    protected function seoFields()
    {
        return [
            Text::make('Заголовок', 'seo_title')
                ->rules('nullable', 'max:255')
                ->hideFromIndex(),

            Markdown::make('Описание', 'seo_description')
                ->rules('nullable')
                ->hideFromIndex(),
        ];
    }
}
