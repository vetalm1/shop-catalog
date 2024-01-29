<?php

namespace App\Nova;

use App\Support\Enums\ContactPlaceType;
use App\Support\Enums\ContactsType;
use App\Support\Enums\FormType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

use Outl1ne\NovaSortable\Traits\HasSortableRows;

class FormOrder extends Resource
{
    public static $model = \App\Models\FormOrder::class;
    public static $title = 'type';
    public static $search = ['id', 'type', 'name', 'email'];

    public static $group = 'Forms';

    public static function label() {return 'Заявки (заказы)';}

    public static function singularLabel() {return 'Заявка';}

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

            Text::make('ФИО', 'name'),
            Text::make('Компании', 'company_name'),
            Text::make('Тел.', 'phone'),
            Text::make('email', 'email')->hideFromIndex(),
            Text::make('Комментарий', 'comment')->hideFromIndex(),
            Text::make('id товара', 'product_id')->hideFromIndex(),
            Text::make('Наименование', 'product_name'),
            Text::make('Кол-во', 'quantity'),

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
