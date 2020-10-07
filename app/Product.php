<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = []; // Allows for import to all fields

    public function demostock() {
        return $this->hasMany('App\Demostock')
    }
}
