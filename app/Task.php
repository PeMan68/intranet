<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Area;
use App\Priority;

class Task extends Model
{
    protected $fillable = [
		'name',
		];

	public function area(){
		return $this->BelongsTo('App\Area');
	}

	public function priority(){
		return $this->BelongsTo('App\Priority','prio_id');
	}
}
