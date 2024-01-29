<?php

namespace App\Nova;

use App\Support\Enums\MainPageTabType;
use App\Support\Enums\SliderType;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class SocialNetwork extends Resource
{
    use HasSortableRows;

    public static $model = \App\Models\SocialNetwork::class;
    public static $title = 'title';
    public static $search = ['id', 'title', 'link', 'is_active'];

    public static $group = 'Other';

    public static function label()
    {
        return 'Социальные сети';
    }

    public static function singularLabel()
    {
        return 'Социальная сеть';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Наименование', 'name')
                ->sortable()
                ->rules('max:255'),

            Text::make('Заголовок', 'title')
                ->sortable()
                ->rules('max:255'),

            Text::make('Ссылка ', 'link')
                ->rules('max:255'),

            Boolean::make('Опубликовано', 'is_active')->sortable(),

            /*Images::make('Изображение', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function($originalFilename, $extension, $model){
                    return md5($originalFilename) . '.' . $extension;
                }),
            */
        ];
    }
}
