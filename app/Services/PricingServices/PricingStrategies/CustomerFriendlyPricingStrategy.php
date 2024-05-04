<?php

namespace App\Services\PricingServices\PricingStrategies;

use App\Models\Accommodation;

class CustomerFriendlyPricingStrategy extends PricingStrategy
{

    public function calculate(Accommodation $accommodation, array $data): float
    {
        dd('customer');
    }
}
