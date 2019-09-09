<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarCategory extends Model
{
	public function calendarEntry() {
		return $this->hasMany(App\CalendarEntry);
	}
}
