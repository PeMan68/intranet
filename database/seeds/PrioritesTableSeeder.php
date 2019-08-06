<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert([
            'hours' => 1,
            'description' => '1 Timme',
        ]);
        DB::table('priorities')->insert([
            'hours' => 4,
            'description' => '4 Timmar',
        ]);
        DB::table('priorities')->insert([
            'hours' => 24,
            'description' => '1 Dag',
        ]);
        DB::table('priorities')->insert([
            'hours' => 48,
            'description' => '2 Dagar',
        ]);
        DB::table('priorities')->insert([
            'hours' => 168,
            'description' => '1 Vecka',
        ]);
        DB::table('priorities')->insert([
            'hours' => 336,
            'description' => '2 Veckor',
        ]);
        DB::table('priorities')->insert([
            'hours' => 720,
            'description' => '1 Månad',
        ]);
    }
}
