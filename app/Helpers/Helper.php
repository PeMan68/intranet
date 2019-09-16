<?php
use App\Charts\BookBillBudPrev;
use App\User;
use App\CalendarEntry;

 
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

if (!function_exists('load_chart_data')){
    /**
     * Load data to chart
     *
     * @param array  $chart
     * @return array $chart
     *
     */
	function load_chart_data()
    {
        $chart = new BookBillBudPrev;
		$chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 
						'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']);
		
		$Billing = array();
		for ($i=0; $i<12; $i++){
			array_push($Billing,  rand(5000, 7000));
		}
		$chart->dataset('Billing', 'bar', $Billing)->options(['backgroundColor' => '#6F6']);
		$Booking = array();
		for ($i=0; $i<12; $i++){
			array_push($Booking,  rand(5000, 7000));
		}
		$chart->dataset('Booking', 'bar', $Booking)->options(['backgroundColor' => '#FB6']);
		$Budget = array();
		for ($i=0; $i<12; $i++){
			array_push($Budget,  rand(5000, 7000));
		}
		$chart->dataset('Budget', 'bar', $Budget)->options(['backgroundColor' => '#FF6']);
		$Previous = array();
		for ($i=0; $i<12; $i++){
			array_push($Previous,  rand(5000, 7000));
		}
		$chart->dataset('Föregående', 'bar', $Previous)->options(['backgroundColor' => '#6BF']);
		return $chart;
    }

}

if (!function_exists('load_calendar_data')){
    /**
     * Load data to calendar
     *
     * @param int $period
     * @return array $data
     *
     */
	function load_calendar_data($request, $chart, $period = 14){
		if ($request->has('datePage')) {
			$dateStart = $request->datePage;
		} else {
			$dateStart = strtotime('-2 days');
		}
			
		$activeusers = User::where('active',1)
						->where('calendar',1)
						->get()->sortBy('roles');
		$datestop = strtotime('+'.$period.' days', $dateStart);
		$entries = CalendarEntry::where('start','<=', date('Y-m-d', $datestop))
			->where('stop', '>=', date('Y-m-d', $dateStart))
			->get()->sortBy('start');
		$data = [
				'users' => $activeusers,
				'start' => $dateStart,
				'stop' => $datestop,
				'activities' => $entries,
				'chart' => $chart,
				];
		return $data;
	}
}
