<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class PropertyGroup extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\PropertyGroup::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'slug'];

    public static $group = 'Каталог';

    public static function label()
    {
        return 'Группы характеристик';
    }

    public static function singularLabel()
    {
        return 'Группа';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Название', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug', 'slug')
                ->from('name')
                ->rules('nullable', 'max:255')
                ->hideFromIndex(),

            HasMany::make('Характеристики', 'properties', Property::class),

            Boolean::make('Опубликован', 'is_active')
                ->sortable(),
        ];
    }
}
