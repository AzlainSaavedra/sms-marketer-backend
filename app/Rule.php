<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['type', 'name'];

    protected $hidden= ['created_at','updated_at'];

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
