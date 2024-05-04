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
    public function create(array $data): bool
    {
        $fromDate = Carbon::parse($data['from_date']);
        $toDate = Carbon::parse($data['to_date']);

        $numberOfDays = $fromDate->diffInDays($toDate) + 1;

        $calendars = [];
        for ($i = 0; $i < $numberOfDays; $i++) {
            $currentDate = $fromDate->copy()->addDays($i);
            $calendars[] = [
                'accommodation_id' => $data['accommodation_id'],
                'date' => $currentDate,
                'base_price' => $data['base_price'],
                'adult_price' => $data['adult_price'],
                'child_price' => $data['child_price'],
                'infant_price' => $data['infant_price'],
            ];
        }

        return Calendar::insert($calendars);
    }
    public function search(array $data, PricingService $pricingService)
    {
        $accommodations = $this->getAccommodationsByDateFilters($data['checkin'], $data['checkout']);

        $accommodations = $pricingService
            ->calculate($accommodations, collect($data)->only('adult_count', 'child_count', 'infant_count')->toArray())
            ->map(function ($accommodation) {
                return $accommodation->only(['id', 'name', 'occupancy', 'total_price', 'requested_nights']);
            });

        if (isset($data['min_price']) or isset($data['max_price'])) {
            $accommodations = $this->filterAccommodationsByPrice($accommodations, collect($data)
                ->only('min_price', 'max_price')->toArray());
        }

        return $accommodations;
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

    private function filterAccommodationsByPrice(Collection $accommodations, array $data)
    {
        return $accommodations
            ->when(isset($data['min_price']), function ($query) use ($data) {
                return $query->where('total_price', '>=', $data['min_price']);
            })
            ->when(isset($data['max_price']), function ($query) use ($data) {
                return $query->where('total_price', '<=', $data['max_price']);
            });
    }
}
