<?php

use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'hours' => 1,
            'description' => '1 Timme',
        ]);
        DB::table('priorities')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'hours' => 4,
            'description' => '4 Timmar',
        ]);
        DB::table('priorities')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'hours' => 24,
            'description' => '1 Dag',
        ]);
        DB::table('priorities')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'hours' => 48,
            'description' => '2 Dagar',
        ]);
        DB::table('priorities')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'hours' => 168,
            'description' => '1 Vecka',
        ]);
        DB::table('priorities')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'hours' => 336,
            'description' => '2 Veckor',
        ]);
        DB::table('priorities')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'hours' => 720,
            'description' => '1 Månad',
        ]);
    }
}
