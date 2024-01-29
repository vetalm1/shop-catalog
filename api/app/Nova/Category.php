<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Category extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\Category::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'slug', 'sync_uuid'];

    public static bool $resolveParentBreadcrumbs = false;

    //public static function authorizedToCreate(Request $request) { return false; }
    //public function authorizedToDelete(Request $request) { return false; }
    //public function authorizedToUpdate(Request $request) { return false; }

    public static $group = 'Каталог';

    public static function label()
    {
        return 'Категории';
    }

    public static function singularLabel()
    {
        return 'Категория';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('1C UUID', 'sync_uuid')
                ->rules('required', 'max:255')->hideFromIndex(),

            Text::make('Название', 'name')->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug', 'slug')
                ->from('name')->rules('nullable', 'max:255')->hideFromIndex(),

            Text::make('Заголовок', 'title')
                ->rules('nullable', 'max:255')->hideFromIndex(),

            Textarea::make('Описание', 'description')
                ->hideFromIndex(),

            Trix::make('Описание (скрытое)', 'hidden_description')
                ->rules('nullable')
                ->hideFromIndex(),

            Textarea::make('Текст для карточки в каталоге ур.', 'card_short_description')
                ->rules('nullable', 'max:600')->hideFromIndex(),

            BelongsTo::make('Родительская категория', 'parent', Category::class)
                ->sortable()->nullable(),

            Images::make('Изображение', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                }),

            Images::make('Изображение для меню', 'menu_image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                }),

            Boolean::make('Опубликовано', 'is_active')
                ->sortable(),

            BelongsToMany::make('Товары', 'products', Product::class),

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

    public function actions(NovaRequest $request)
    {
        return [
            new Actions\ActivateAction(),
            new Actions\DeactivateAction()
        ];
    }
}
