<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEntry extends Model
{
	protected $fillable = ['description','start','stop','calendarcategory_id','user_id'];
	
	/**
     * Many-To-One relationship to CalendarCategory
     *
	 * An entry in the calendar has only one type of category
	 *
     * @return void
     */
    public function calendarCategory(){
		return $this->belongsTo(App\CalendarCategory);
	}
	
	/**
     * Many-To-One relationship to User
     *
	 * An entry in the calendar has only one user
	 *
     * @return void
     */
	public function user(){
		return $this->belongsTo(App\User);
	}
}
