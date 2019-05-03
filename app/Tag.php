<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /*Many To many relationship*/
    public function questions(){
        return $this->belongsToMany('App\Question','question_tags','tag_id','question_id')
            ->withTimestamps();
    }
}
