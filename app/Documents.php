<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
		'filename',
		'size',
		'user_id',
		'version',
		'description',
		];
	
	public function user() {
		return $this->belongsTo('App\User');
	}	
}
