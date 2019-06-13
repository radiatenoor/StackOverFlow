<?php

namespace App;

use App\Notifications\AdminResetNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $hidden = ['password','remember_token'];

    public function user_role(){
        return $this->hasOne(UserRole::class,'admin_id','id');
    }

    public function hasRole($role){
        $user_role = $this->user_role()
            ->with('role')
            ->first();
        if ($user_role->role->slug==$role){
            return true;
        }
        return false;
    }

    public function hasRolePermission($permission){
        $user_role = $this->user_role()
            ->with('role')
            ->first();
        foreach ($user_role->role->permissions as $permsn){
            if ($permsn->slug==$permission){
                return true;
                break;
            }
        }
        return false;
    }

    /**
     * Override from CanResetPassword Trait
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetNotification($token));
    }

}
