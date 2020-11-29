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
        'user_id', 
        'issue_id',
        'path',
        'filename',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function issue() {
		return $this->belongsTo('App\Issue');
    }
}
