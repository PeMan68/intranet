<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [];

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    public function childrenLocations()
    {
        return $this->hasMany('App\Location')->with('locations');
    }

    public function hasAnyChildren()
    {
        return null !== $this->locations()->where('location_id', $this->id)->first();
    }
}
