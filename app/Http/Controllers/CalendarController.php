<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarSearchRequest;
use App\Services\CalendarService;
use App\Services\PricingServices\PricingService;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct(protected CalendarService $calendarService, protected PricingService $pricingService)
    {
    }
    public function store()
    {

    }

    public function update()
    {

    }

    public function search(CalendarSearchRequest $request)
    {
       /* $results =*/ $this->calendarService->search($request->validated(), $this->pricingService);

//        return response()->json($results, 200);
    }
}
