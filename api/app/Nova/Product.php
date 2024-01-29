<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Product extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\Product::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'slug', 'sync_uuid', 'art', 'description'];

    public static function usesScout()
    {
        return false;
    }

    public static $resolveParentBreadcrumbs = false;

    public static $group = 'Каталог';

    public static function label()
    {
        return 'Товары';
    }

    public static function singularLabel()
    {
        return 'Товар';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('1C UUID', 'sync_uuid')
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Text::make('Название', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug', 'slug')
                ->from('name')
                ->hideFromIndex()
                ->rules('nullable', 'max:255'),

            Text::make('Артикул', 'art')
                ->rules('required', 'max:255'),

            Currency::make('Стоимость', 'price')
                ->step(1),

            Number::make('Остатки', 'balance')->step(1),

            Text::make('Заголовок', 'title')
                ->rules('max:255')
                ->hideFromIndex(),

            Trix::make('Описание', 'description')
                ->rules('nullable')
                ->hideFromIndex(),

            Trix::make('Описание (скрытое)', 'hidden_description')
                ->rules('nullable')
                ->hideFromIndex(),

            HasMany::make('Похожие товары', 'similarProducts', SimilarProduct::class)
                ->nullable(),

            BelongsToMany::make('Категория', 'categories', Category::class),

            BelongsTo::make('Бренд', 'brand', Brand::class)
                ->searchable()
                ->nullable(),

            HasMany::make('Свойства', 'propertyValues', PropertyValue::class),

            Images::make('Изображение', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                }),

            Images::make('Галерея изображений', 'image-gallery')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                })->hideFromIndex(),

            Files::make('Видео', 'video'),

            Boolean::make('Опубликовано', 'is_active')
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
