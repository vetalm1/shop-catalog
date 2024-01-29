<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

use Outl1ne\NovaSortable\Traits\HasSortableRows;

class FailedJob extends Resource
{

    public static $model = \App\Models\FailedJob::class;
    public static $title = 'order_id';
    public static $search = ['id', 'order_id', 'order_number', 'amount', 'payment_status'];

    public static $group = 'Other';

    public static function label()
    {
        return ' Упавшие задачи';
    }

    public static function singularLabel()
    {
        return 'задача';
    }

    public static $perPageOptions = [20, 50, 100];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('uuid', 'uuid')->sortable(),
            Text::make('connection', 'connection')->sortable(),
            Text::make('queue', 'queue')->sortable(),

            Textarea::make('payload', 'payload')->hideFromIndex(),
            Textarea::make('exception', 'exception')->hideFromIndex(),

            Text::make('failed_at', 'failed_at'),
        ];
    }
}
