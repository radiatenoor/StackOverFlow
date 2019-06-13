<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = ['role_id'];

    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
}
