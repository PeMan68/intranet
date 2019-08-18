<?php

use Illuminate\Database\Seeder;
use App\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Task::truncate();
		
		Task::create([
				'area_Id' => 2,
				'prio_id' => 1,
				'name' => 'Mjukstart',
			]);
		Task::create([
				'area_Id' => 1,
				'prio_id' => 3,
				'name' => 'Fel Pris',
			]);
    }
}
