<?php

namespace App\Services\PricingServices\PricingStrategies;

use App\Models\Accommodation;

class CustomerFriendlyPricingStrategy extends PricingStrategy
{

    public function calculate(Accommodation $accommodation, array $data): float
    {

        return $this->calculateTotalBasePrice($accommodation->calendars) + $this->calculateTotalAdditionalPrice($accommodation, $data);
    }

    private function calculateTotalAdditionalPrice(Accommodation $accommodation, array $data): float
    {
        $totalAdditionalPrice = 0;

        $additionalNumber = array_sum($data) - $accommodation->occupancy;

        foreach ($accommodation->calendars as $calendar) {
            $totalAdditionalPricePerDay = 0;
            $additionalNumberPerDay = $additionalNumber;

            collect([
                'adult' => [
                    'count' => $data['adult_count'],
                    'price' => $calendar->adult_price
                ],
                'child' => [
                    'count' => $data['child_count'],
                    'price' => $calendar->child_price
                ],
                'infant' => [
                    'count' => $data['infant_count'],
                    'price' => $calendar->infant_price
                ],
            ])->sortBy(function ($item) {
                return $item['price'];
            })->map(function ($personCategory) use (&$additionalNumberPerDay, &$totalAdditionalPricePerDay) {
                if ($additionalNumberPerDay >= $personCategory['count']) {
                    $count = $personCategory['count'];
                } else {
                    $count = $additionalNumberPerDay;
                }

                $additionalNumberPerDay -= $count;

                $totalAdditionalPricePerDay += ($count * $personCategory['price']);
            });

            $totalAdditionalPrice += $totalAdditionalPricePerDay;
        }

        return $totalAdditionalPrice;
    }
}
