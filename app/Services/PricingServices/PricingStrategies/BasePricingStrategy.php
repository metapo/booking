<?php

namespace App\Services\PricingServices\PricingStrategies;

use App\Models\Accommodation;

class BasePricingStrategy extends PricingStrategy
{
    public function calculate(Accommodation $accommodation, array $data): float
    {
        return 1000;
        dd($accommodation->calendars, $data);
    }
}
