<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = []; // Allows for import to all fields

    public function demoproduct() 
    {
        return $this->hasMany('App\Demoproduct');
    }
}
