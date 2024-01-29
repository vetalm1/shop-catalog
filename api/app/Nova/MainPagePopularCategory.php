<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class MainPagePopularCategory extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\MainPagePopularCategory::class;
    public static $title = 'title';
    public static $search = ['id', 'title', 'category'];

    public static $group = 'Catalog';

    public static function label()
    {
        return 'Популярные категории';
    }

    public static function singularLabel()
    {
        return 'Популярная категория';
    }

    public function fields(NovaRequest $request)
    {
        return [

            BelongsTo::make('Категория', 'category', Category::class)
                ->searchable()
                ->display(function ($model) {
                    return $model->parent
                        ? $model->parent->name . ' / ' . $model->name
                        : $model->name . ' ( род.)';
                }),

            Text::make('Заголовок', 'title')
                ->sortable()
                ->rules('max:255'),

        ];
    }
}
