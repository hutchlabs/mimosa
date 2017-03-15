<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Gradlead\Job;
use App\Gradlead\Organization;
use App\Jobs\ProcessAlerts;

class Alert extends Model
{
    protected $table = 'users_alerts';

    protected $guarded = [];

    protected $hidden = [];
       
    protected function getArrayableAppends()
    {
        $appends = ['jobs','link','templates']; 
        $this->appends = array_merge($this->appends, $appends);
        return parent::getArrayableAppends();
    }
    
    public function getJobsAttribute() 
    {
        $terms = trim($this->sc($this->language).' '.
                      $this->sc($this->job_type).' '.
                      $this->sc($this->category));
        $locs = trim($this->country.' '.$this->city.' '.$this->neighborhood);
        $user = User::find($this->user_id);
        $res = Job::search($user, $terms, $locs);
        return $res['all'];
    }
        
    public function getLinkAttribute() 
    {
        $terms = trim($this->sc($this->language).' '.
                      $this->sc($this->job_type).' '.
                      $this->sc($this->category));
        $locs = trim($this->country.' '.$this->city.' '.$this->neighborhood);
        return '/home?page=sp&q='.$terms.'&l='.$locs;
    }
    
    public function getTemplatesAttribute() 
    {
        $user = DB::table('users')
            ->select(DB::raw('id,organization_id,first,last,uuid,type,email'))
            ->where('id',$this->user_id)
            ->first(); 
        $org = Organization::find($user->organization_id);
        return $org->templates;
    }
    
    public function user() 
    {
        return $this->belongsTo('\App\User');
    }

    public function updateNextRunDate()
    {
        $this->next_run_date = Alert::setNextRun($this->frequency, $this->next_run_date);
        $this->save();
    }
    
    public function scopeTodaysAlerts($query) 
    {
        $today = date('Y-m-d');
        return $query->whereRaw('DATE(next_run_date) = ?',array($today))->get();
    } 
    
    public static function setNextRun($frequency='daily', $d=null)
    {
        $d = ($d==null) ? date('Y-m-d') : $d;
        $date = '';
        switch($frequency) {
            case 'weekly': $date = date('Y-m-d',strtotime($d.' +1 week')); break;
            case 'monthly': $date = date('Y-m-d',strtotime($d.' +1 month')); break;
            default: $date = date('Y-m-d',strtotime($d.' +1 day'));
        }
        return $date;
    }
        
    public static function sendAlerts()
    {
        $alerts = Alert::TodaysAlerts();
        foreach($alerts as $alert) {
            dispatch((new ProcessAlerts($alert))->onQueue('alerts'));
        }
    }
    
    private function sc($term) { return preg_replace('/,/',' ',$term); }
}
