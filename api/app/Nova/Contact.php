<?php

namespace App\Nova;

use App\Support\Enums\ContactPlaceType;
use App\Support\Enums\ContactsType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Contact extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\Contact::class;
    public static $title = 'type';
    public static $search = ['id', 'type', 'place', 'value'];

    public static $group = 'Other';

    public static function label() {return 'Контактные данные';}

    public static function singularLabel() {return 'контакт';}

    public static function authorizedToCreate(Request $request) { return false; }
    public function authorizedToDelete(Request $request) { return false; }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Select::make('Тип (тел.,email, адрес)', 'type')
                ->options(ContactsType::getSelectData())
                ->rules('required', 'max:255')
                ->displayUsingLabels(),

            Select::make('Место размещения', 'place')
                ->options(ContactPlaceType::getSelectData())
                ->rules('required', 'max:255')
                ->displayUsingLabels(),

            Text::make('Значение', 'value')->hideFromIndex(),

            Text::make('Значение','value')
                ->displayUsing(function($value) {
                    if (strlen($value) > 60) {
                        $part = mb_substr($value, 0, 60);
                        return $part . " ...";
                    }
                    return $value;
                })->onlyOnIndex(),

            Boolean::make('Опубликован', 'is_active')->sortable(),
        ];
    }

}
