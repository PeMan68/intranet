<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
	public function user() {
		return $this->belongsTo('App\User','user_id');
	}
	
	public function names() {
		return $this->hasMany('App\Visitor_name','visitor_id');
	}
}
