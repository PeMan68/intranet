<?php

use Illuminate\Database\Seeder;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'area' => 'Kundsupport',
        ]);
        DB::table('areas')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'area' => 'Teknisk support',
        ]);
        DB::table('areas')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'area' => 'Ekonomi',
        ]);
        DB::table('areas')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'area' => 'Reklamation',
        ]);
        DB::table('areas')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'area' => 'Marknadsföring',
        ]);
        DB::table('areas')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'area' => 'Administration',
        ]);
        DB::table('areas')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'area' => 'Personligt',
        ]);
    }
}
