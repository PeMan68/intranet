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
        return $this->hasMany('App\Location')->orderBy('name');
    }

    public function childrenLocations()
    {
        return $this->hasMany('App\Location')->orderBy('name')->with('locations');
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

    public function path()
    {
        $name=$this->name;
        if ($this->hasParent()) {
            $parent = $this->parent;
            $name = $parent->name . ' > ' . $name;
            while ($parent->hasParent()) {
                $parent = $parent->parent;
                $name = $parent->name . ' > ' . $name;
            }
        }
        return $name;
    }

    public function deletable()
    {
        if (!$this->hasAnyChildren() && !count($this->demoProducts)) {
            return true;
        }
        return false;
    }
}
