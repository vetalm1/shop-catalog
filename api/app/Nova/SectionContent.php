<?php

namespace App\Nova;

use App\Support\Enums\SectionContentType;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class SectionContent extends Resource
{
    //use HasSortableRows;

    public static $model = \App\Models\SectionContent::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'title', 'description'];

    public static $group = 'Other';

    public static function label()
    {
        return 'Контент страниц (секций)';
    }

    public static function singularLabel()
    {
        return 'Контент для секции';
    }

    public function fields(NovaRequest $request)
    {
        $model = \App\Models\SectionContent::find(request()->resourceId);
        $model ? $canSee = false : $canSee = true;

        /*скрываем лишние блоки в зависимости от типа (type), */
        return [
            ID::make()->sortable(),

            BelongsTo::make('Секция', 'seoSection', 'App\Nova\SeoSection')
                ->withMeta(['extraAttributes' => ['readonly' => true]]),

            Text::make('Описание/наименование', 'name')->sortable()->rules('required', 'max:255')
                ->withMeta(['extraAttributes' => ['readonly' => true]]),

            Select::make('Тип', 'type')
                ->options(SectionContentType::getSectionContentTypes())
                ->displayUsingLabels()->withMeta(['extraAttributes' => ['readonly' => true]]),

            /*текстовый блок*/
            Text::make('Заголовок', 'title')->sortable()->rules('max:255')
                ->canSee(function () use ($model, $canSee) {
                    return $canSee || $model->type === SectionContentType::Textblock->value;
                }),
            Trix::make('Текст', 'description')->sortable()->rules('max:1000')
                ->canSee(function () use ($model, $canSee) {
                    return $canSee || $model->type === SectionContentType::Textblock->value;
                }),

            /*блок со списком*/
            Text::make('Заголовок списка', 'list_title')->hideFromIndex()->rules('max:255')
                ->canSee(function () use ($model, $canSee) {
                    return $canSee || $model->type === SectionContentType::List->value;
                }),
            KeyValue::make('Список', 'list')->hideFromIndex()->rules('max:5000')
                ->canSee(function () use ($model, $canSee) {
                    return $canSee || $model->type === SectionContentType::List->value;
                }),

            Images::make('Изображение', 'image')
                ->enableExistingMedia()->showStatistics()
                ->setFileName(function($originalFilename, $extension, $model){
                    return md5($originalFilename) . '.' . $extension;
                }),
            Images::make('Галерея изображений', 'images')
                ->enableExistingMedia()->showStatistics()->hideFromIndex()
                ->setFileName(function($originalFilename, $extension, $model){
                    return md5($originalFilename) . '.' . $extension;
                }),

            //Text::make('№', 'order_column')->help('Порядковый номер (для сортировки)'),

            Boolean::make('Активн.', 'is_active')->sortable(),
        ];
    }
}
