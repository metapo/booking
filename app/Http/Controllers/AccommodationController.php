<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccommodationRequest;
use App\Models\Accommodation;
use App\Services\AccommodationService;

class AccommodationController extends Controller
{
    public function store(AccommodationRequest $request, AccommodationService $accommodationService)
    {
        return $accommodationService->create($request->validated());
    }

    public function update(AccommodationRequest $request, Accommodation $accommodation, AccommodationService $accommodationService)
    {
        $accommodationService->update($accommodation, $request->validated());
    }
}
