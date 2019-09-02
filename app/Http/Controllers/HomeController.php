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
		$period = 20;
		$activeusers = User::all()->sortBy('roles');
		$datestart = strtotime('-7 days');
		$datestop = strtotime('+'.$period.' days', $datestart);
		$entries = CalendarEntry::where('start','<=', date('Y-m-d', $datestop))
			->where('stop', '>=', date('Y-m-d', $datestart))
			->get();
		$data = [
				'users' => $activeusers,
				'start' => $datestart,
				'stop' => $datestop,
				'activities' => $entries,
				];
		return view('home',$data);
    }
}
