<?php

namespace App\Nova;

use App\Support\Enums\ContactPlaceType;
use App\Support\Enums\ContactsType;
use App\Support\Enums\FormType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Question extends Resource
{
    public static $model = \App\Models\Question::class;
    public static $title = 'type';
    public static $search = ['id', 'type', 'name', 'phone'];

    public static $group = 'Forms';

    public static function label() {return 'Вопросы';}

    public static function singularLabel() {return 'Вопрос';}

    public static function authorizedToCreate(Request $request) { return false; }
    public function authorizedToDelete(Request $request) { return false; }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Select::make('Форма', 'type')
                ->options(FormType::getSelectData())
                ->rules('required', 'max:255')
                ->displayUsingLabels(),

            Text::make('ФИО (компания)', 'name'),
            Text::make('Тел.', 'phone'),
            Text::make('email', 'email'),
            Markdown::make('Вопрос', 'question'),


            Boolean::make('Просмотрено', 'is_viewed')->sortable(),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            new Actions\MarkAsViewedAction(),
            new Actions\MarkAsNotViewedAction()
        ];
    }

}
