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
        'taskPersonal_id',
        'task_id',
		'userCreate_id',
		'userCurrent_id', 
		'customer',
		'customerNumber',
        'customerName',
		'customerTel',
		'customerMail',
		'paused',
		'waitingForReply',
		'vip',
		'nextIssue_id',
		'previousIssue_id',
		'description',
		'descriptionInternal',
		'timeClosed',
		'timeInit',
		'timeEstimatedcallback',
		'timeCustomercallback'
    ];
	
	public function userCreate() {
		return $this->belongsTo('App\User','id','userCreate_id');
	}

	public function userCurrent() {
		return $this->belongsTo('App\User','id','userCurrent_id');
	}

	public function issueComments()	{
		return $this->hasMany('App\IssueComment');
	}
	
	public function task() {
		return $this->belongsTo('App\Task');
	}
}
