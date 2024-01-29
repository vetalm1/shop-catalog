<?php

namespace App\Nova;

use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class SyncData extends Resource
{
    public static $model = \App\Models\SyncData::class;
    public static $title = 'type';
    public static $search = ['type', 'request', 'data'];

    public static $group = 'Other';

    public static function label()
    {
        return 'Sync Data';
    }

    public static function singularLabel()
    {
        return 'Sync Data';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Text', 'text'),
            Text::make('Type-sync', 'type'),
            Text::make('Request', 'request'),
            Date::make('Data', 'data')->hideFromIndex(),
            Date::make('Data-create', 'created_at'),
        ];
    }
}
