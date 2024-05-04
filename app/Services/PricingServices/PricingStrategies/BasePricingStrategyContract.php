<?php

namespace App\Services\PricingServices\PricingStrategies;

use App\Models\Accommodation;

class BasePricingStrategyContract extends PricingStrategy
{
    public function calculate(Accommodation $accommodation, array $data): float
    {
        dd($accommodation->calendars, $data);
    }
}
