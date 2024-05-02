<?php

namespace App\Enums;

trait CommonEnumTrait
{
    public static function all(): array
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
