<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Visitor;

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
		$data = load_calendar_data($request, $chart, 14);
		$day1ofweek = strtotime("this week");
		$day5ofweek = strtotime("+4 days", $day1ofweek);
		$visitors = Visitor::where([
			['start','>=',date("Y-m-d", $day1ofweek)],
			['stop','<=',date("Y-m-d", $day5ofweek)],
			])->get();
			$data['visitors'] = $visitors;
		return view('home',$data);
    }
}
