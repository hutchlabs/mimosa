<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';

    protected $guarded = [];

    protected $hidden = [];
    
    public function contracts()
    {
        return $this->hasMany('\App\Gradlead\Contract', 'plan_id', 'id');
    }
}
