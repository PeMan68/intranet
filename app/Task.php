<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Area;
use App\Priority;

class Task extends Model
{
	public function area(){
		return $this->hasOne('App\Area');
	}

	public function priority(){
		return $this->hasOne('App\Priority');
	}
}
