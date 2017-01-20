<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'users_alerts';

    protected $guarded = [];

    protected $hidden = [];
    
    public function user() 
    {
        return $this->belongsTo('\App\Gradlead\User');
    }
    
    public function createSchedule()
    {
                // TODO: Schedule alerts
    }
}
