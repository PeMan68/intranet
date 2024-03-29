<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demoproduct extends Model
{
    protected $guarded = [];

    public function location() 
    {
        return $this->belongsTo('App\Location', 'location_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function status()
    {
        return $this->belongsTo('App\ProductStatus', 'status_id');
    }

    public function tracking()
    {
        return $this->hasMany('App\TrackDemoproduct');
    }
}
