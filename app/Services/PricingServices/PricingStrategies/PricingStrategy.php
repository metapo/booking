<?php

namespace App\Services\PricingServices\PricingStrategies;

interface PricingStrategy
{
    public function calculate(): float;
}
