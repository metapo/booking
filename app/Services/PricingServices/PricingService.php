<?php

namespace App\Services\PricingServices;


use Illuminate\Database\Eloquent\Collection;

class PricingService
{
    public function calculate(Collection $accommodations, array $data)
    {
        return $accommodations->transform(function ($accommodation) use ($data) {
            $pricingStrategy = PricingStrategyFactory::make($data, $accommodation->occupancy);
            return $pricingStrategy->calculate($accommodation, $data);
            $accommodation->total_price = 1000;
            return $accommodation;
        });
    }
}
