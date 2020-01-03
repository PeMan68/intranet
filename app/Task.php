<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Area;
use App\Priority;

class Task extends Model
{
	protected $fillable = [
		'area_id', 
		'prio_id',
		'name',
	];

	public function area(){
		return $this->BelongsTo('App\Area');
	}

	public function priority(){
		return $this->BelongsTo('App\Priority','prio_id');
	}
	
	public function users(){
		return $this->belongsToMany('App\User');
	}
}
