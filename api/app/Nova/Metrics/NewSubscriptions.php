<?php

namespace App\Nova\Metrics;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

class NewSubscriptions extends Value
{
    public function name()
    {
        return 'New subscriptions';
    }
    /**
     * Calculate the value of the metric.
     *
     * @param Request $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Subscription::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => '30 Days',
            60 => '60 Days',
            365 => '365 Days',
            'MTD' => 'Month To Date',
            'QTD' => 'Quarter To Date',
            'YTD' => 'Year To Date',
        ];
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'new-subscriptions';
    }
}
