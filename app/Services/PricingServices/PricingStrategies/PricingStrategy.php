<?php

namespace App\Services\PricingServices\PricingStrategies;

use App\Models\Accommodation;

interface PricingStrategy
{
    public function calculate(Accommodation $accommodation, array $data): float;
}
