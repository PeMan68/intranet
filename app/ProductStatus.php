<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    protected $guarded = [];

    public function products() {
        return $this->hasMany('App\Demoproduct', 'status_id');
    }

    public function hasAnyProducts() {
        return null !== $this->products()->first();
    }
}
