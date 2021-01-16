<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
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
