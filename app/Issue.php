<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'userCreate',
		'userCurrent', 
		'description',
        'task',
		'customer',
		'customerNumber',
        'customerName',
		'customerTel',
		'customerMail',
		'paused',
		'waitingForReply',
		'vip',
		'prio',
		'nextIssueID',
		'previousIssueID',
		'description',
		'descriptionInternal',
		'timeClosed',
		'timeInit',
		'timeEstimatedcallback',
		'timeCustomercallback'
    ];
	
	public function timeLogs()
	{
		return $this->hasMany('App\TimeLog');
	}
}
