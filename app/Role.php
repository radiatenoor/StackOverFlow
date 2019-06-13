<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function permissions(){
        return $this->belongsToMany(Permission::class,'role_permissions'
            ,'role_id','permission_id');
    }


    public function admin(){
        return $this->hasOne(UserRole::class,'role_id','id');
    }
}
