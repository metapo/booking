<?php

namespace App\Services\PricingServices\PricingStrategies;

use App\Models\Accommodation;

interface PricingStrategyContract
{
    public function calculate(Accommodation $accommodation, array $data): float;
}
