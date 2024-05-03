<?php

namespace App\Services;

use App\Models\Accommodation;

class AccommodationService
{
    public function create(array $data): Accommodation
    {
        return Accommodation::create($data);
    }

    public function update(Accommodation $accommodation, array $data): Accommodation|bool
    {
        $accommodation->fill($data);

        if (!$accommodation->isDirty()) {
            return false;
        }

        return $accommodation->save();
    }
}
