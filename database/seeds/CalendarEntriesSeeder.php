<?php

use Illuminate\Database\Seeder;
use App\CalendarEntry;

class CalendarEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CalendarEntry::truncate();
		
		/*
		$adminRole = Role::where('name', 'admin')->first();
		$saleRole = Role::where('name', 'sale')->first();
		$supportRole = Role::where('name', 'support')->first();
		$userRole = Role::where('name', 'user')->first();
		*/
		
		for ($i=1; $i<50; $i++){
			$userid = rand(1,4);
			$categoryid = rand(1,4);
			$timestamp = strtotime('-1 month');
			$startdate = rand($timestamp, strtotime('12 months',$timestamp));
			$stopdate = strtotime('+ ' . rand(1,40) . ' days', $startdate);
			
			CalendarEntry::create([
				'start' => date('Y-m-d',$startdate),
				'stop' => date('Y-m-d',$stopdate),
				'calendarcategory_id' => $categoryid,
				'user_id' => $userid,
				'description' => Str::random(10),
			]);
		};
    }
}
