<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'users_address';

    protected $guarded = [];

    protected $hidden = [];
    
    public function user() 
    {
        return $this->belongsTo('\App\Gradlead\User');
    }
}
