<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarRequest;
use App\Http\Requests\CalendarSearchRequest;
use App\Services\CalendarService;
use App\Services\PricingServices\PricingService;

class CalendarController extends Controller
{
    public function __construct(protected CalendarService $calendarService, protected PricingService $pricingService)
    {
    }
    public function store(CalendarRequest $request)
    {
        $results = $this->calendarService->create($request->validated());
    }

    public function search(CalendarSearchRequest $request)
    {
        $results = $this->calendarService->search($request->validated(), $this->pricingService);

        return response()->json($results, 200);
    }
}
