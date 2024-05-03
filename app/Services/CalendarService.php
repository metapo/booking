<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalendarService
{
    public function search(array $data)
    {
        $checkin = Carbon::parse($data['checkin']);
        $checkout = Carbon::parse($data['checkout']);

        $daysInRange = $checkin->diffInDays($checkout);

        $accommodations = Accommodation
            ::whereHas(
                'calendars', function ($query) use ($checkin, $checkout, $daysInRange) {
                $query
                    ->select('accommodation_id', DB::raw('COUNT(DISTINCT date) as days_count'))
                    ->whereBetween('date', [$checkin, $checkout])
                    ->where('is_reserved', false)
                    ->groupBy('accommodation_id')
                    ->having(DB::raw('COUNT(DISTINCT date)'), '=', $daysInRange);
            })
            ->with(['calendars' => function ($query) use ($checkin, $checkout) {
                $query->whereBetween('date', [$checkin, $checkout]);
            }])
            ->get();

    }
}
