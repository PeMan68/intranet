<?php

use Illuminate\Database\Seeder;
use App\CalendarCategory;

class CalendarCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		CalendarCategory::truncate();
		
		CalendarCategory::create([
				'name' => 'Info',
				'url_image' => 'images/blue.png',
			]);
		CalendarCategory::create([
				'name' => 'Ledig',
				'url_image' => 'images/green.png',
			]);
		CalendarCategory::create([
				'name' => 'Preliminärt ledig',
				'url_image' => 'images/lightgreen.png',
			]);
		CalendarCategory::create([
				'name' => 'Tjänsteresa',
				'url_image' => 'images/orange.png',
			]);
		CalendarCategory::create([
				'name' => 'Sjuk',
				'url_image' => 'images/yellow.png',
			]);
    }
}
