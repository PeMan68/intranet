<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $guarded = []; // Allows for import to all fields

    public function demoproduct() 
    {
        return $this->hasMany('App\Demoproduct');
    }

    public function replacements()
    {
        return $this->belongsToMany('App\Product','products_replacements','product_id','replacement_product_id')
            ->withPivot('comment')
            ->withTimestamps();
    }
    
    public function replaces()
    {
        return $this->belongsToMany('App\Product','products_replacements','replacement_product_id','product_id')
        ->withPivot('comment')
        ->withTimestamps();
    }
}
