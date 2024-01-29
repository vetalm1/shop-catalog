<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Faq extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\Faq::class;
    public static $title = 'title';
    public static $search = ['id', 'question', 'answer'];

    public static $group = 'Other';

    public static function label() {return 'Вопрос-Ответ';}

    public static function singularLabel() {return 'Вопрос';}

    public static $perPageOptions = [20, 50, 100];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Вопрос', 'question')->onlyOnIndex(),
            Textarea::make('Вопрос', 'question'),
            Trix::make('Ответ', 'answer'),

            Boolean::make('Опубликован', 'is_active')->sortable(),
        ];
    }

}
