<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\NewFormQuestions;

use App\Nova\Metrics\NewSubscriptions;
use App\Nova\Metrics\NewUsers;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    public function name()
    {
        return 'Main data board';
    }

    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            //new NewFormQuestions(),
            //new NewSubscriptions(),
            //new NewUsers()
        ];
    }
}
