<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['email', 'password','rule_id','api_token','firstName','secondName','lastName','secondLastName','phone','address','status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];

    public function setPasswordAttribute($pass){

        $this->attributes['password'] = \Hash::make($pass);

    }

    public function client()
    {
        return $this->hasOne('App\Client');
    }

    public function rule()
    {
        return $this->belongsTo('App\Rule');
    }
}
