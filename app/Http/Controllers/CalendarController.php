<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarSearchRequest;
use App\Services\CalendarService;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct(protected CalendarService $calendarService)
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
       /* $results =*/ $this->calendarService->search($request->validated());

//        return response()->json($results, 200);
    }
}
