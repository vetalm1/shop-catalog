<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class DeactivateAction extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Снять с публикации';

    public function handle(ActionFields $fields, Collection $models)
    {
        DB::transaction(function () use ($models) {
            foreach ($models as $model) {
                $model->is_active = false;
                $model->save();
            }
        });
    }
}
