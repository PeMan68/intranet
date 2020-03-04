<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor_name extends Model
{
    protected $fillable = [
        'name', 'visitor_id',
    ];
}
