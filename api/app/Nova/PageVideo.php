<?php

namespace App\Nova;

use App\Support\Enums\MainPageTabType;
use App\Support\Enums\SliderType;
use App\Support\Enums\VideoPagesType;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
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

class PageVideo extends Resource
{
    use HasSortableRows;

    public static function authorizedToCreate(Request $request) { return false; }
    public function authorizedToReplicate(Request $request) { return false; }
    public function authorizedToDelete(Request $request) { return false; }

    public static string $model = \App\Models\PageVideo::class;
    public static $title = 'title';
    public static $search = ['id', 'page', 'button_text', 'is_active'];

    public static $group = 'Other';

    public static function label()
    {
        return 'Видео для разных страниц';
    }

    public static function singularLabel()
    {
        return 'Видео';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Select::make('Страница', 'page')
                ->options(VideoPagesType::getSelectData())
                ->rules('required', 'max:255')
                ->displayUsingLabels()->readonly(),

            Text::make('Текст кнопки', 'button_text')
                ->sortable()
                ->rules('max:255'),

            Text::make('Ссылка видео', 'link')
                ->rules('max:255')->hideFromIndex(),

            Boolean::make('Опубликовано', 'is_active')->sortable(),

            Images::make('Изображение', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function($originalFilename, $extension, $model){
                    return md5($originalFilename) . '.' . $extension;
                }),
            Files::make('Файл', 'video-file'),
        ];
    }
}
