<?php

 
if (!function_exists('add_responsibilites')) {
    /**
     * Updates the users responsibilities from actual tasks in table tasks.
     *
	 * When a new task is added to tasks, 
	 * or a user is added to users, the column responsibilities in table users
	 * needs to be updated, so all users have a level of responsibility for
	 * each available task. 0 is inserted as new level. When a user logs on this
	 * is monitored and the user must enter a correct level for the new task(s).
	 *
     * @return void
     *
     */
    function add_responsibilites()
    {
		$tasks = App\Task::all();
		$users = App\User::all();
		foreach ($users as $user){
			foreach ($tasks as $task){
				$respExist=false;
				foreach ($user->responsibilities as $k => $v){
					if ($k == $task->name) {
						$respExist = true;
						echo 'Responsibility för '.$task->name.' finns för användare '.$user->name.'<br>';
						break;
					}
				}
				if (!$respExist){
					echo 'Responsibility för '.$task->name.' fanns inte för användare '.$user->name.'. ';
					$k = $task->name;
					$user->responsibilities = array_merge($user->responsibilities,array($k => 0));
					$user->save();
					echo $k.' Tillagt.<br>';
				}
				
			}
			
		}
    }
}

if (!function_exists('delete_responsibilites')) {
    /**
     * Deletes the users responsibilities is task no longer exist in table tasks.
     *
	 * When a new task is dropped from tasks, 
	 * the column responsibilities in table users
	 * needs to be updated, so all users have a level of responsibility for
	 * each available task. 0 is inserted as new level. When a user logs on this
	 * is monitored and the user must enter a correct level for the new task(s).
	 *
     * @return void
     *
     */
    function delete_responsibilites()
    {
		$tasks = App\Task::all();
		$users = App\User::all();
		foreach ($users as $user){
			foreach ($user->responsibilities as $k => $v){
				$respExist=false;
				foreach ($tasks as $task){
					if ($k == $task->name) {
						$respExist = true;
						//echo 'Task '.$task->name.' finns för användare '.$user->name.'<br>';
						break;
					}
				}
				if (!$respExist){
					echo 'Responsibility '.$k.' finns inte i tasks. ';
					$arr=$user->responsibilities;
					unset($arr[$k]);
					$user->responsibilities = $arr;
					$user->save();
					echo $k.' raderad.<br>';
				}
				
			}
			
		}
    }
}