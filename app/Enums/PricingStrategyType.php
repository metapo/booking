<?php

namespace App\Enums;

enum PricingStrategyType: string
{
    case BASE = 'base';
    case CUSTOMER_FRIENDLY = 'customer_friendly';

    case OWNER_FRIENDLY = 'owner_friendly';
}
