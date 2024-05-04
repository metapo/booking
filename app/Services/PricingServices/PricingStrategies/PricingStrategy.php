<?php

namespace App\Services\PricingServices\PricingStrategies;

use Illuminate\Database\Eloquent\Collection;

abstract class PricingStrategy implements PricingStrategyContract
{
    protected function calculateTotalBasePrice(Collection $calendars): float
    {
        return $calendars->sum('base_price');
    }
}
