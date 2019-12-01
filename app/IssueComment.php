<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssueComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issue_id', 'user_id', 'comment_internal', 'comment_external', 
    ];

    //
	public function issues() {
		return $this->belongsTo('App\Issue');
	}
    //
	public function users() {
		return $this->belongsTo('App\User');
	}
}
