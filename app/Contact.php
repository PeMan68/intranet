<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    public function issueComments()
    {
        return $this->hasMany('App\IssueComment');
    }

    public function issues()
    {
        return $this->hasMany('App\Issue');
    }
}
