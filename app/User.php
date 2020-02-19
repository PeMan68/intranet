<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'active', 'calendar', 'responsibilities',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
		'responsibilities' => 'array',
		'active' => 'boolean',
		'calendar' => 'boolean'
    ];
	
	public function departments(){
		return $this->belongsToMany('App\Department');
	}

	public function hasAnyDepartments($departments){
		return null !== $this->departments()->whereIn('name', $departments)->first();
	}
	
	public function hasAnyDepartment($department){
		return null !== $this->departments()->where('name', $department)->first();
	}
	
	public function roles(){
		return $this->belongsToMany('App\Role');
	}
	
	public function hasAnyRoles($roles){
		return null !== $this->roles()->whereIn('name', $roles)->first();
	}

	public function hasAnyRole($role){
		return null !== $this->roles()->where('name', $role)->first();
	}

	public function tasks(){
		return $this->belongsToMany('App\Task')
			->withPivot('level')
			->withTimestamps();
	}
	
	public function tasksHighestPriority(){
		return $this->belongsToMany('App\Task')
			->wherePivot('level','3')
			->withPivot('level');
	
	}
	
	public function hasAnyTasks($tasks){
		return null !== $this->tasks()->whereIn('name', $tasks)->first();
	}

	public function hasAnyTask($task){
		return null !== $this->tasks()->where('name', $task)->first();
	}

	public function calendarEntry() {
		return $this->hasMany('App\CalendarEntry');
	}

	public function issueComments() {
		return $this->hasMany('App\IssueComment');
	}

	public function issues() {
		return $this->hasMany('App\Issue','userCreate_id');
	}

	public function followingIssues() {
		return $this->belongsToMany('App\Issue')
			->withTimestamps();
	}
	
    /**
     * Generate initials from a name
     *
     * @param string $name
     * @return string
     */
    public function initials()
    {
        $name = $this->name.' '.$this->surname;
		$words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
        }
        return $this->makeInitialsFromSingleWord($name);
    }

    /**
     * Make initials from a word with no spaces
     *
     * @param string $name
     * @return string
     */
    protected function makeInitialsFromSingleWord(string $name) : string
    {
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return substr(implode('', $capitals[1]), 0, 2);
        }
        return strtoupper(substr($name, 0, 2));
    }
}
