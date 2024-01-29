<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Mostafaznv\NovaCkEditor\CkEditor as CkEditor5;
use Waynestate\Nova\CKEditor4Field\CKEditor as CKEditor4;

class TemplatePage extends Resource
{
    public static $model = \App\Models\TemplatePage::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'slug', 'title'];

    public static $group = 'Other';

    public static function label()
    {
        return 'Шаблонные страницы';
    }

    public static function singularLabel()
    {
        return 'Шаблонная страница';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Наименование', 'name')->sortable()->rules('required', 'max:255'),
            Slug::make('Слаг', 'slug')
                ->from('name')
                ->hideFromIndex(),

            Text::make('Заголовок', 'title'),
            //CKEditor4::make('Текст', 'description')->withFiles('public_media'), /* old version ckeditor 4 */
            CkEditor5::make('Текст', 'description'), /* new version ckeditor 5 */

            Images::make('Изображение', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function($originalFilename, $extension, $model){
                    return md5($originalFilename) . '.' . $extension;
                }),

            Boolean::make('Опубликована', 'is_active')->sortable(),
            new Panel('SEO', $this->seoFields()),
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
