<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ResponsibleEmployee extends Resource
{
    public static $model = \App\Models\ResponsibleEmployee::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'email'];

    public static $group = 'other';

    public static function label()
    {
        return 'Ответственные сотрудники';
    }

    public static function singularLabel()
    {
        return 'Ответственный сотрудник';
    }

    public static $perPageOptions = [20, 50, 100];


    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('ФИО(имя)', 'name')->rules('required', 'max:255'),
            Text::make('email', 'email')->rules('required', 'max:255'),
        ];
    }

}
