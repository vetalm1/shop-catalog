<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class MarkAsNotViewedAction extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'отметить как "НЕ просмотрено"';

    public function handle(ActionFields $fields, Collection $models)
    {
        DB::transaction(function () use ($models) {
            foreach ($models as $model) {
                $model->is_viewed = false;
                $model->save();
            }
        });
    }
}
