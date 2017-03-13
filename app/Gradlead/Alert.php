<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

use App\Gradlead\Job;

class Alert extends Model
{
    protected $table = 'users_alerts';

    protected $guarded = [];

    protected $hidden = [];
       
    protected function getArrayableAppends()
    {
        $appends = ['jobs'];
                
        $this->appends = array_merge($this->appends, $appends);

        return parent::getArrayableAppends();
    }
    
    public function getJobsAttribute() 
    {
        $res = Job::search(null, "", "");
        return $res['all'];
    }
    
    public function user() 
    {
        return $this->belongsTo('\App\Gradlead\User');
    }

    public function createSchedule()
    {
                // TODO: Schedule alerts
    }
}
