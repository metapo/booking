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
        $accommodations = Accommodation::factory(30)->create();

        foreach ($accommodations as $accommodation) {
            Calendar::factory(30)
                ->sequence(fn ($sequence) => ['date' => now()->addDays($sequence->index)])
                ->for($accommodation) // ارتباط با اقامتگاه
                ->create();
        }
    }
}
