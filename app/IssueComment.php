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
        'issue_id', 'user_id', 'comment', 'checkin', 'checkout', 'contact_id', 'direction', 'type'
    ];

    //
	public function issue() {
		return $this->belongsTo('App\Issue');
	}
    //
	public function user() {
		return $this->belongsTo('App\User');
    }
    
    public function contact() {
        return $this->belongsTo('App\Contact')->withDefault(['name'=>'*anonym*']);
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
			->where('comment', '<>', '');
	}
}
