<?php

namespace App\Services\PricingServices;

use App\Enums\PricingStrategyType;
use App\Services\PricingServices\PricingStrategies\BasePricingStrategyContract;
use App\Services\PricingServices\PricingStrategies\CustomerFriendlyPricingStrategyContract;
use App\Services\PricingServices\PricingStrategies\OwnerFriendlyPricingStrategyContract;
use App\Services\PricingServices\PricingStrategies\PricingStrategyContract;

class PricingStrategyFactory
{
    public static function make(array $requestedCount, int $occupancy): PricingStrategyContract
    {
        return new BasePricingStrategyContract();
        if (array_sum($requestedCount) <= $occupancy) {
            return new BasePricingStrategyContract();
        }

        $strategyName = config('pricing.strategy');
        return match (PricingStrategyType::tryFrom($strategyName)) {
            PricingStrategyType::CUSTOMER_FRIENDLY => new CustomerFriendlyPricingStrategyContract(),
            PricingStrategyType::OWNER_FRIENDLY => new OwnerFriendlyPricingStrategyContract(),
            default => throw new \InvalidArgumentException("Invalid pricing strategy: $strategyName")
        };
    }
}
