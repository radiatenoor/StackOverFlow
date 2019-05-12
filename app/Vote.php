<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public function question(){
        return $this->belongsTo(Question::class,'question_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
