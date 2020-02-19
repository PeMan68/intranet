<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::truncate();
		
		Department::create(['name' => 'Reception', 'sort' => 1]);
		Department::create(['name' => 'Kontor', 'sort' => 2]);
		Department::create(['name' => 'Ekonomi', 'sort' => 3]);
		Department::create(['name' => 'Lager', 'sort' => 4]);
		Department::create(['name' => 'Kundsupport', 'sort' => 5]);
		Department::create(['name' => 'Teknisk support', 'sort' => 6]);
		Department::create(['name' => 'Innesälj', 'sort' => 7]);
		Department::create(['name' => 'Utesälj', 'sort' => 8]);
    }
}
