<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\CalendarEntry;
use App\Helpers\Helper;

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
    public function index(Request $request )
    {
		$chart = load_chart_data();
		$period = 14;
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
		return view('home',$data);
    }
}
