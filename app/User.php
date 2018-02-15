<?php

namespace App;

use App\SocialAccount;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function socialAccounts(){
        return $this->hasMany(SocialAccount::class);
    }

    public function deliveries(){
        return $this->hasMany(delivery::class);
    }

    public function roles(){
        return $this->belongsToMany('App\Role');
    }
}
