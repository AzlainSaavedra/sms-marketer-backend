<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = ['email','firstName','secondName','lastName','secondLastName','phone','address','idType','idClient','businessName'];

    protected $hidden= ['created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
