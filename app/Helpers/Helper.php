<?php

 
if (!function_exists('update_responsibilites')) {
    /**
     * Updates the users responsibilities from actual tasks in table tasks.
     *
	 * When a new task is added to tasks, or a task is dropped from tasks,
	 * the json column in table users needs to be updated, so all users have the 
	 * correct responsibility for each available task.
	 *
     * @return void
     *
     * */
    function update_responsibilites()
    {
		$tasks = App\Task::all();
		$users = App\User::all();
		foreach ($users as $user){
			foreach ($tasks as $task){
				$respExist=false;
				foreach ($user->responsibilities as $k => $v){
					echo $k.':'.$v;
					if ($k == $task->name) {
						$respExist = true;
						echo 'Responsibility för '.$task->name.' finns ('. $k.')<br>';
						break;
					}
				}
				if (!$respExist){
					echo 'Responsibility för '.$task->name.' fanns inte.';
					$k = $task->name;
					$user->responsibilities = array_merge($user->responsibilities,array($k => 0));
					$user->save();
					echo $k.' Tillagt.<br>';
				}
				
			}
			
		}
    }
}