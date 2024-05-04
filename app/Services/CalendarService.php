<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Models\Calendar;
use App\Services\PricingServices\PricingService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CalendarService
{
    public function search(array $data, PricingService $pricingService)
    {
        $accommodations = $this->getAccommodationsByDateFilters($data['checkin'], $data['checkout']);

        $pricingService->calculate($accommodations, collect($data)
            ->only('adult_count', 'child_count', 'infant_count')->toArray());
        dd($accommodations);
    }

    private function getAccommodationsByDateFilters(string $checkin, string $checkout): Collection
    {
        $checkin = Carbon::parse($checkin);
        $checkout = Carbon::parse($checkout);

        $daysInRange = $checkin->diffInDays($checkout);

        return Accommodation::select(['id', 'name', 'occupancy'])
            ->whereHas(
                'calendars', function ($query) use ($checkin, $checkout, $daysInRange) {
                $query
                    ->select('accommodation_id', DB::raw('COUNT(DISTINCT date) as days_count'))
                    ->whereBetween('date', [$checkin, $checkout])
                    ->where('is_reserved', false)
                    ->groupBy('accommodation_id')
                    ->having(DB::raw('COUNT(DISTINCT date)'), '=', $daysInRange);
            })
            ->with(['calendars' => function ($query) use ($checkin, $checkout) {
                $query
                    ->select(['accommodation_id', 'base_price', 'adult_price', 'child_price', 'infant_price'])
                    ->whereBetween('date', [$checkin, $checkout]);
            }])
            ->get();
    }
}
