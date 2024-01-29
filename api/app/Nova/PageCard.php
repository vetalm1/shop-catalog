<?php

namespace App\Nova;

use App\Support\Enums\ContactPlaceType;
use App\Support\Enums\ContactsType;

use App\Support\Enums\PageCardType;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

use Laravel\Nova\Http\Requests\NovaRequest;

use Outl1ne\NovaSortable\Traits\HasSortableRows;

class PageCard extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\PageCard::class;
    public static $title = 'type';
    public static $search = ['id', 'type', 'place', 'value'];

    public static $group = 'Other';

    public static function label() {return 'Карточки для страниц';}

    public static function singularLabel() {return 'Карточку';}

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Select::make('Тип карточки', 'type')
                ->options(PageCardType::getSelectData())
                ->displayUsingLabels(),

            Text::make('Заголовок', 'title'),
            Text::make('Ссылка', 'link'),
            //Text::make('Наименование страницы отображения', 'page_name'),

            Boolean::make('Большая карточка', 'is_big')->sortable(),

            Images::make('Изображение для карточки', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function ($originalFilename, $extension, $model) {
                    return md5($originalFilename) . '.' . $extension;
                })->hideFromIndex(),

            Boolean::make('Опубликован', 'is_active')->sortable(),
        ];
    }

}
