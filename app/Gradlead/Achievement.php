<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Achievement extends Model
{
    protected $table = 'badges_achievements';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['badge'];

    public function badge() {
        return $this->hasOne('\App\Gradlead\Badge');
    }    
}
