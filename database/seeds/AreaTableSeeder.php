<?php

use Illuminate\Database\Seeder;
use App\Area;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete all records
		Area::truncate();
		
		Area::create([
            'area' => 'Kundsupport',
        ]);
        Area::create([
            'area' => 'Teknisk support',
        ]);
        Area::create([
            'area' => 'Ekonomi',
        ]);
        Area::create([
            'area' => 'Reklamation',
        ]);
        Area::create([
            'area' => 'Marknadsföring',
        ]);
        Area::create([
            'area' => 'Administration',
        ]);
        Area::create([
            'area' => 'Personligt',
        ]);
    }
}
