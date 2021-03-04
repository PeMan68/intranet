<?php

use App\Charts\BookBillBudPrev;
use App\User;
use App\Issue;
use App\IssueComment;
use App\CalendarEntry;
use Illuminate\Support\Facades\Cache;

if (!function_exists('check_out_issue')) {
	/**
	 * Check out issue 
	 *
	 * @param array  $issue
	 * @param array  $new_comment
	 * @return array $new_comment
	 *
	 */
	function check_out_issue($issue)
	{
		//Checkout issue only if it is not already checked out
		if (is_null($issue->userCurrent_id) || !Cache::has('user-is-online-' . $issue->userCurrent_id)) {
			Issue::whereId($issue->id)
				->update(['userCurrent_id' => Auth::user()->id]);
		}
		$new_comment = new IssueComment;
		$new_comment->issue_id = $issue->id;
		$new_comment->user_id = Auth::id();
		$new_comment->checkout = date('Y-m-d H:i:s', strtotime(now()));
		$new_comment->Save();

		return $new_comment;
	}
}

if (!function_exists('check_in_issues')) {
	/**
	 * Check in all issues currently open by active user
	 * Close timelog for current user/comment
	 *
	 * @return void
	 *
	 */
	function check_in_issues()
	{
		// Set null to all issues where current user is active
		Issue::where('userCurrent_id', Auth::user()->id)
			->update(['userCurrent_id' => null]);

		// Find all open comments for active user and close them
		$openIssues = IssueComment::where('user_id', Auth::user()->id)
			->where('checkin', null)->get();
		foreach ($openIssues as $i) {
			$i->update(['checkin' => check_in_time($i->checkout)]);
		}
	}
}

if (!function_exists('check_in_time')) {
	/**
	 * If checkout is today, return now
	 * If checkout is before today, return checkout
	 *
	 * @return DateTime
	 *
	 */
	function check_in_time($checkout)
	{
		if (date('Y-m-d', strtotime($checkout)) == date('Y-m-d', strtotime(now()))) {
			return date('Y-m-d H:i', strtotime(now()));
		} else {
			return date('Y-m-d H:i', strtotime($checkout));
		}
	}
}

if (!function_exists('load_chart_data')) {
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
		$chart->labels([
			'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep',
			'Okt', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'
		]);
		$file = config('imports.path_prevBilling') . '/' . config('imports.file_prevBilling');
		$csv = explode(",", file_get_contents($file));
		$chart->dataset('Föregående', 'bar', $csv)->options(['backgroundColor' => '#FFBB00']);

		$file = config('imports.path_budget') . '/' . config('imports.file_budget');
		$csv = explode(",", file_get_contents($file));
		$chart->dataset('Budget', 'bar', $csv)->options(['backgroundColor' => '#F65314']);

		$file = config('imports.path_booking') . '/' . config('imports.file_booking');
		$csv = explode(",", file_get_contents($file));
		$chart->dataset('Booking', 'bar', $csv)->options(['backgroundColor' => '#7CBB00']);

		$file = config('imports.path_billing') . '/' . config('imports.file_billing');
		$csv = explode(",", file_get_contents($file));
		$chart->dataset('Billing', 'bar', $csv)->options(['backgroundColor' => '#00A1F1']);

		return $chart;
	}
}

if (!function_exists('load_calendar_data')) {
	/**
	 * Load data to calendar
	 *
	 * @param int $period
	 * @return array $data
	 *
	 */
	function load_calendar_data($request, $chart, $period = 14)
	{
		if ($request->has('datePage')) {
			$dateStart = $request->datePage;
		} else {
			$dateStart = strtotime('-2 days');
		}

		$activeusers = User::where('active', 1)
			->where('calendar', 1)
			->get()->sortBy(function ($u) {

				return [$u->departments->sort()];
			});


		$datestop = strtotime('+' . $period . ' days', $dateStart);
		$entries = CalendarEntry::where('start', '<=', date('Y-m-d', $datestop))
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

if (!function_exists('setting')) {
	/**
	 * Get value for key from database
	 *
	 * @param string $key
	 * @return array $key
	 *
	 */
	function setting($key, $default = null)
	{
		if (is_null($key)) {
			return new \App\Setting();
		}

		if (is_array($key)) {
			return \App\Setting::set($key[0], $key[1]);
		}

		$value = \App\Setting::get($key);

		return is_null($value) ? value($default) : $value;
	}
}

if (!function_exists('readableBytes')) {

	/**
	 * Converts a long string of bytes into a readable format e.g KB, MB, GB, TB, YB
	 * 
	 * @param {Int} num The number of bytes.
	 */
	function readableBytes($bytes)
	{
		$i = floor(log($bytes) / log(1024));

		$sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

		return sprintf('%.0F', $bytes / pow(1024, $i)) * 1 . ' ' . $sizes[$i];
	}
}

if (!function_exists('unansweredIssues')) {
	function unansweredIssues()
	{
		$tasks = DB::table('task_user')
			->where('user_id', Auth::id())
			->where('level', 3)
			->get();
		$i = Issue::whereNull('timeClosed')
			->whereIn('task_id', $tasks->pluck('task_id'))
			->get();
		return $i->count();
	}
}

if (!function_exists('expiredIssues')) {
	function expiredIssues()
	{
		$data = Issue::whereNull('timeCustomercallback')
			->whereNull('timeClosed')
			->where(function ($query) {

				$query->whereDate('timeEstimatedcallback', '<', date('Y-m-d'))
					->orWhere(function ($query) {
						$query->whereDate('timeEstimatedcallback', '=', date('Y-m-d'))
							->whereTime('timeEstimatedcallback', '<', date('H:i:s'));
					});
			})
			->get();
		return $data->count();
	}
}

if (!function_exists('nextWorkingDateTime')) {
	/**
	 * Calculate the DateTime a number of working-minutes from now
	 * 
	 * @param int $minutes
	 * 
	 * @return DateTime $datetimeValue
	 */
	function nextWorkingDateTime(int $minutes = 0){
		
		// $hourWorkStart = 8;
		// $hourWorkStop = 16;
		$hourWorkStart = setting('start_hour_workingday');
		$hourWorkStop = setting('stop_hour_workingday');
		
		$dateTimeNow = now();
		
		$dateTimeWorkdayStart = now()->setDateTime(
			$dateTimeNow->year,
			$dateTimeNow->month,
			$dateTimeNow->day,
			$hourWorkStart,
			0
		);
		$dateTimeWorkdayStop = now()->setDateTime(
			$dateTimeNow->year,
			$dateTimeNow->month,
			$dateTimeNow->day,
			$hourWorkStop,
			0
		);
		
		// Move the Starttime depending on if we are before, within or after the workinghours
		if ($dateTimeNow < $dateTimeWorkdayStart) {
			$dateTimeTemporary = $dateTimeWorkdayStart;
		} elseif ($dateTimeNow > $dateTimeWorkdayStop) {
			$dateTimeTemporary = $dateTimeWorkdayStart->addDay();
		} else {
			$dateTimeTemporary = $dateTimeNow;
		}

		$dateTimeTemporary = nextWorkingDay($dateTimeTemporary);
		
		// Move time ahead workinghours while counting down remaining time
		$minutesDiff = $minutes;
		while ($dateTimeTemporary->hour + $minutesDiff/60 > $hourWorkStop) {
			$minutesDiff = ($dateTimeTemporary->hour + $minutesDiff/60 - $hourWorkStop) * 60;
			$dateTimeTemporary = now()->setDateTime(
				$dateTimeTemporary->year,
				$dateTimeTemporary->month,
				$dateTimeTemporary->day+1,
				$hourWorkStart,
				$dateTimeTemporary->minute,
			);
			$dateTimeTemporary = nextWorkingDay($dateTimeTemporary);
		}
		
		// Add the reamining minutes
		$datetimeValue = $dateTimeTemporary->addMinutes($minutesDiff);

		return $datetimeValue;
	}
}

if (!function_exists('nextWorkingDay')) {
	/**
	 * @param DateTime $datetime
	 * 
	 * @return DateTime $datetime
	 */
	function nextWorkingDay(DateTime $datetime) {
		// While day is not workday, add one day to datetime
		while ($datetime->dayOfWeek > 5 || $datetime->dayOfWeek == 0) {
			$datetime = $datetime->addDay();
		}
		return $datetime;
	}
}
