<?php

namespace App\Services\PricingServices\PricingStrategies;

use App\Models\Accommodation;

class CustomerFriendlyPricingStrategy extends PricingStrategy
{
    use SortFriendlyPricingStrategyTrait;
    public function calculate(Accommodation $accommodation, array $data): float
    {

        return $this->calculateTotalBasePrice($accommodation->calendars) + $this->calculateTotalAdditionalPrice($accommodation, $data);
    }

    protected function getSortOrder(): string
    {
        return 'asc';
    }
}
