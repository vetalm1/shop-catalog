<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class VerificationCode extends Resource
{
    public static $model = \App\Models\VerificationCode::class;
    public static $title = 'name';
    public static $search = ['id', 'phone', 'email', 'code'];

    public static $group = 'Other';

    public static function label()
    {
        return 'VerificationCodes';
    }

    public static function singularLabel()
    {
        return 'VerificationCode';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('phone', 'phone')->sortable(),
            Text::make('email', 'email')->sortable(),
            Text::make('code', 'code')->sortable(),
            Text::make('created_at', 'created_at')->sortable(),
        ];
    }

}
