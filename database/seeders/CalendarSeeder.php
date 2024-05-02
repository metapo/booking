<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accommodation = Accommodation::factory()->create();

        Calendar::factory(30)
            ->consecutiveDates(30)
            ->for($accommodation)
            ->create();
    }
}
