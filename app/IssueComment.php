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
        'issue_id', 'user_id', 'comment_internal', 'comment_external', 'checkin', 'checkout'
    ];

    //
	public function issues() {
		return $this->belongsTo('App\Issue');
	}
    //
	public function users() {
		return $this->belongsTo('App\User');
	}
	/**
     * Scope a query exclude models without any comment.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
	public function scopeHasComments($query)
	{
		return $query
			->where('comment_internal', '<>', '')
			->OrWhere('comment_external', '<>', '');
	}
}
