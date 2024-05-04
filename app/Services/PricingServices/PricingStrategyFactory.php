<?php

namespace App\Services\PricingServices;

use App\Enums\PricingStrategyType;
use App\Services\PricingServices\PricingStrategies\BasePricingStrategy;
use App\Services\PricingServices\PricingStrategies\CustomerFriendlyPricingStrategy;
use App\Services\PricingServices\PricingStrategies\OwnerFriendlyPricingStrategy;
use App\Services\PricingServices\PricingStrategies\PricingStrategy;

class PricingStrategyFactory
{
    public static function make(array $requestedCount, int $occupancy): PricingStrategy
    {
        return new BasePricingStrategy();
        if (array_sum($requestedCount) <= $occupancy) {
            return new BasePricingStrategy();
        }

        $strategyName = config('pricing.strategy');
        return match (PricingStrategyType::tryFrom($strategyName)) {
            PricingStrategyType::CUSTOMER_FRIENDLY => new CustomerFriendlyPricingStrategy(),
            PricingStrategyType::OWNER_FRIENDLY => new OwnerFriendlyPricingStrategy(),
            default => throw new \InvalidArgumentException("Invalid pricing strategy: $strategyName")
        };
    }
}
