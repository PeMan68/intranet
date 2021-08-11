<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackDemoproduct extends Model
{
    protected $fillable = ['demoproduct_id', 'to_location_id', 'from_location_id', 'user_id', 'comment'];
    
    public function to_location()
    {
        return $this->belongsTo('App\Location', 'to_location_id');
    }

    public function from_location()
    {
        return $this->belongsTo('App\Location', 'from_location_id');
    }

}
