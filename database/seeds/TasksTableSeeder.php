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
				'areaId' => 2,
				'proposedPrioId' => 1,
				'task' => 'Mjukstart',
			]);
		DB::table('tasks')->insert([
				'created_at' => now(),
				'updated_at' => now(),
				'areaId' => 1,
				'proposedPrioId' => 3,
				'task' => 'Fel Pris',
			]);
    }
}
