<?php

namespace App;
use Illuminate\Support\Facades\Auth;
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
		'timeCustomercallback',
		'prio',
		'ticketNumber',
		'header',
    ];
	
	public function namePersonalTask(){
		if($this->taskPersonal_id<>0) {
			return $this->belongsTo('App\User','taskPersonal_id');
		}
	}
	public function userCreate() {
		return $this->belongsTo('App\User','userCreate_id');
	}

	public function userCurrent() {
		return $this->belongsTo('App\User','userCurrent_id');
	}

	public function issueComments()	{
		return $this->hasMany('App\IssueComment');
	}
	
	public function latestComment() {
		return $this->hasOne('App\IssueComment')->where('comment_internal','!=',null)->latest();
	}

	public function task() {
		return $this->belongsTo('App\Task');
	}
	
	public function followers() {
		return $this->belongsToMany('App\User')
			->withTimestamps();
	}
	
	public function scopeFilter($query, $filter)
	{
		if (isset($filter)){
			$query->where('customer', 'LIKE', '%' . $filter . '%')
					->orWhere('customerNumber', 'LIKE', '%' . $filter . '%')
					->orWhere('customerMail', 'LIKE', '%' . $filter . '%')
					->orWhere('customerTel', 'LIKE', '%' . $filter . '%')
					->orWhere('customerName', 'LIKE', '%' . $filter . '%')
					->orWhere('description', 'LIKE', '%' . $filter . '%')
					->orWhere('descriptionInternal', 'LIKE', '%' . $filter . '%')
					->orWhere('ticketNumber', 'LIKE', '%' . $filter . '%')
			;
		}
		return $query;
	}
	
	public function userCurrentLevel() {
		$level = 0;
		if (!is_null(Auth::user()->tasks()->find($this->task_id)))
		{
			$level = Auth::user()->tasks()->find($this->task_id)->pivot->level;
		}
		return $level;
	}
	
	public function hoursToCallback() {
		if (!is_null($this->timeCustomercallback)){
			$hours=0;
		} else {
			$hours = (strtotime($this->timeEstimatedcallback)-strtotime(date('Y-m-d H:i:s'))) / 3600;
		}
		return $hours;
	}

    /**
     * Calculate the priority for an issue.
	 * Higher priority => higher value
     *
     * @var array
     */
	public function getCalculatedPrioAttribute()
	{
		$level = self::userCurrentLevel();
		$prio = ($level +1) * $this->prio;
		if ($this->vip) {
			$prio *= 4; 
		}
		if ($this->taskPersonal_id == Auth::id()) {
			$prio *=2;
		}
		if (!is_null($this->timeCustomercallback)) {
			$prio /=5;
		}
		if ($this->waitingForReply) {
			$prio /=10;
		}
		if ($this->paused) {
			$prio /=10;
		}
		$hours = self::hoursToCallback();
		if ($hours<>0) {
			if (abs($hours) == $hours) {
				//future
			} else {
				$prio *= -$hours;
			}
		}
		if (!is_null($this->timeClosed)) {
			$prio = 0;
		}
		return $prio;
	}
}
