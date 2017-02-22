<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Job extends Model
{
    protected $table = 'jobs';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['contract','applications'];

    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['numapplications','orgname','orglogo']);
        return parent::getArrayableAppends();
    }

    public function getNumapplicationsAttribute() 
    {
      return DB::table('jobs_applications')
                ->select(DB::raw('id'))
                ->where('job_id',$this->id)
                ->count(); 
    }
    
    public function getOrgnameAttribute() 
    {
      $i =  DB::table('organizations')
                ->select(DB::raw('name'))
                ->where('id',$this->organization_id)
                ->first(); 
      return (is_null($i)) ? 'Uknown' :  $i->name;
    }
    
    public function getOrglogoAttribute() 
    {
        $logo = 'img/a0.jpg';
        
        $i =  DB::table('organizations')
                ->select(DB::raw('id, type'))
                ->where('id',$this->organization_id)
                ->first(); 
        
        if (!is_null($i)) {
            $profile = ($i->type=='employer') ? ProfileCompany::where('organization_id',$i->id)->first()
                                              : ProfileSchool::where('organization_id', $i->id)->first();
                                                  
            if ($profile && $profile->file_name<>'') {
                $path = ($i->type=='employer') ? 'logo' : 'crest';
                $logo = '/profiles/'.$path.'/'.$profile->id.'?'.date('Y-m-d');
            }
        }
        return $logo;
    }
    
    
    public function organization()
    {
        return $this->belongsTo('\App\Gradlead\Organization');
    }

    public function contract()
    {
        return $this->belongsTo('\App\Gradlead\Contract');
    }
    
    public function questionnaire()
    {
        return $this->hasOne('\App\Gradlead\Questionnaire');
    }

    public function applications()
    {
        return $this->hasMany('\App\Gradlead\Application');
    }

    public function scopeFeatured($query) {
        return $query->where('featured', '=', '1');
    }
    
    public function scopeWhereFeatured($query) {
        return $query->whereHas('contract.plan', function($q) {
    		    $q->where('feature_job', '=', '1');
        });
    }
    
    public function scopeActive($query) {
        return $query->where('status',1)->get();
    }

    public static function featuredJobs()
    {
		//return Job::with('organization')->WhereFeatured()->get();
        return Job::with('organization')->Featured()->get();
    }
     
    public static function myJobs($id)
    {
        $where = 'organization_id = ? OR school_ids LIKE "%,?,%"';
        return Job::whereRaw($where, array($id,$id))->get();
    }
    
    public function setStatus()
    {
        $status = 1;
        
        // check if job end date and plan is still valid
        if (!$this->isValid() || !$this->contract->isValid()) {
            $status = 0;
        }

        $this->status = $status;
    }
    
    public function getFeaturedStatus()
    {
        return ($this->contract->plan->feature_job);
    }
    
    public function isValid()
    {
        return (strtotime($this->end_date) <= strtotime(date('Y-m-d')));
    }
    
    public function doPreselectEvaluation($user)
    {
        $pass = 1;
        $criteria = json_decode($this->preselect);
        
        // TODO: criteria checks
        foreach($criteria as $c) {
            
        }
        
        return $pass; 
    }
    
    public function doScreeningEvaluation($responses)
    {
        $score = 0;
        
        // TODO: score checks
        
        return $score;
    }
}
