<?php

namespace App\Services\PricingServices\PricingStrategies;

use App\Models\Accommodation;

class BasePricingStrategy implements PricingStrategy
{
    public function calculate(Accommodation $accommodation, array $data): float
    {
        dd('base');
    }
}
