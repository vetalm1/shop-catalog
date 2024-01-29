<?php

namespace App\Nova;

use App\Support\Enums\EntityType;
use App\Support\Enums\UserType;
use App\Support\Enums\WorkType;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    public static $model = \App\Models\User::class;
    public static $title = 'namePhone';
    public static $search = ['id', 'name', 'phone', 'email',];

    public function title()
    {
        return $this->phone . ' - ' . $this->name;
    }

    public static $group = 'Users';

    public static function label()
    {
        return 'Пользователи';
    }

    public static function singularLabel()
    {
        return 'Пользователь';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')->sortable()->rules('required', 'max:255'),

            Text::make('Phone')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:users,phone')
                ->updateRules('unique:users,phone,{{resourceId}}')
                ->placeholder('+33(333)333-22-22')
                ->help('phone format: +33(333)333-22-22'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254',
                    function ($attribute, $value, $fail) {
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            return $fail('The ' . $attribute . ' is invalid');
                        }
                    }
                )
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
