<?php

namespace App\Enums;

enum AccommodationType : string
{
    use CommonEnumTrait;

    case HOTEL = 'hotel';
}
