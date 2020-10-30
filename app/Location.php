<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [];

    public function demoProducts() {
        return $this->hasMany('App\Demoproduct');
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

    public function parent()
    {
        return $this->belongsTo('App\Location', 'location_id');
    }

    public function hasParent()
    {
        $result = false;
        if (!is_null($this->location_id)) {
            $result = true;
        }
        return $result;
    }

    public function parentName()
    {
        $name = 'top';
        if ($this->hasParent())
        {
            $name = $this->parent()->value('name');
        }
        return $name;
    }
}
