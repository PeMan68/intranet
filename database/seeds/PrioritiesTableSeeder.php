<?php

use Illuminate\Database\Seeder;
use App\Priority;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::truncate();
		
		Priority::create([
            'hours' => 1,
            'description' => '1 Timme',
        ]);
        Priority::create([
            'hours' => 4,
            'description' => '4 Timmar',
        ]);
        Priority::create([
            'hours' => 24,
            'description' => '1 Dag',
        ]);
        Priority::create([
            'hours' => 48,
            'description' => '2 Dagar',
        ]);
        Priority::create([
            'hours' => 168,
            'description' => '1 Vecka',
        ]);
        Priority::create([
            'hours' => 336,
            'description' => '2 Veckor',
        ]);
        Priority::create([
            'hours' => 720,
            'description' => '1 Månad',
        ]);
    }
}
