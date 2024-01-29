<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class SeoSection extends Resource
{
    public static $model = \App\Models\SeoSection::class;
    public static $title = 'page_description';
    public static $search = ['id', 'page_name', 'page_description'];

    public static $group = 'Other';

    public static function label()
    {
        return 'Страницы СЕО+Контент';
    }

    public static function singularLabel()
    {
        return 'Страница (секция) СЕО+Контент';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Описание', 'page_description')->sortable()->rules('max:255'),
            Text::make('seo_title', 'seo_title')->hideFromIndex()->rules('max:255'),
            Textarea::make('seo_description', 'seo_description')->hideFromIndex()->rules('max:1000'),

            Text::make('Тех.имя', 'page_name')->sortable()->rules('required', 'max:255')
                ->withMeta(['extraAttributes' => ['readonly' => true]]),
            HasMany::make('Контент Секции', 'sectionContents', 'App\Nova\SectionContent'),

            Boolean::make('Активн.', 'is_active')->sortable(),
        ];
    }
}
