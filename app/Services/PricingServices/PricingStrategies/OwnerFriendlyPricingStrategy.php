<?php

namespace App\Services\PricingServices\PricingStrategies;

use App\Models\Accommodation;

class OwnerFriendlyPricingStrategy extends PricingStrategy
{
    public function calculate(Accommodation $accommodation, array $data): float
    {
        dd('owner');
    }
}
