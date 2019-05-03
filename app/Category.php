<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /*One To Many RelationShip*/
    public function question(){
        return $this->hasMany('App\Question','category_id','id');
    }
}
