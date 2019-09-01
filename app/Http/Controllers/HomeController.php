<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\CalendarEntry;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$activeusers = User::all()->sortBy('roles');
		$date = strtotime('-7 days');
		$date2 = $date;
		$period = 20;
		$strdate = array();
		$activities = array();
		for ($i=0; $i<=$period; $i++) {
			$date2 = strtotime('+1 day', $date2);
			$strdate[$i] = $date2;
			$u = 0;
			foreach ($activeusers as $user){
						$entries = CalendarEntry::where('start','<=', date('Y-m-d', $date2))
						->where('stop', '>=', date('Y-m-d', $date2))
						->where('user_id', $user->id)
						->get();

				if (count($entries)>0) {
					$a=0;
					foreach ($entries as $entry) {
						$activities[$i][$u][$a][0] = $entry->id;
						$activities[$i][$u][$a][1] = $entry->user_id;
						$activities[$i][$u][$a][2] = $entry->calendarCategory->url_image;
						$activities[$i][$u][$a][3] = $entry->description;
						$a++;
					};
				} else {
					// set id=0 to indicate an empty day
					$activities[$i][$u][0][0] = 0;					
					$activities[$i][$u][0][1] = 0;					
					$activities[$i][$u][0][2] = '';					
					$activities[$i][$u][0][3] = '';					
				};
				$u++;
			};
		};
		//dd($activities);
		$data = [
				'users' => $activeusers,
				'dates' => $strdate, 
				'period' => $period,
				'activities' => $activities,
				];
		return view('home',$data);
    }
}
