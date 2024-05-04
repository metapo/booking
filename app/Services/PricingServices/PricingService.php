<?php

namespace App\Services\PricingServices;


use Illuminate\Database\Eloquent\Collection;

class PricingService
{
    public function calculate(Collection $accommodations, array $data)
    {
        return $accommodations->transform(function ($accommodation) use ($data) {
            $pricingStrategy = PricingStrategyFactory::make($data, $accommodation->occupancy);
            $accommodation->total_price = $pricingStrategy->calculate($accommodation, $data);
            $accommodation->requested_nights = $accommodation->calendars->count();
            return $accommodation;
        });
    }
}
