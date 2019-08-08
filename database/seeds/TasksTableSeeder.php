<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
				'created_at' => now(),
				'updated_at' => now(),
				'area_Id' => 2,
				'prio_id' => 1,
				'name' => 'Mjukstart',
			]);
		DB::table('tasks')->insert([
				'created_at' => now(),
				'updated_at' => now(),
				'area_Id' => 1,
				'prio_id' => 3,
				'name' => 'Fel Pris',
			]);
    }
}
