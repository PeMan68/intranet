<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssueAttachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issue_id', 'filename',
    ];

    //
	public function issue() {
		return $this->belongsTo('App\Issue');
	}
}
