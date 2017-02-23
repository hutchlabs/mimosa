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
    
    public static function search($user, $keywords, $loc, $dates=null, $remote=null)
    {   
         DB::enableQueryLog();      
        $results = ['count'=>0, 'all'=>[], 'school'=>[], 'other'=>[],'featured'=>[]];
        
        $cases = Job::query();
        
        $fields = ['title','teaser','description_text',
                   'job_types', 'positions','country','city'];
        
        if ($keywords <> '' || $loc <> '') {
            $terms = explode(' ', $keywords);
            $locs = explode(' ', $loc);
            $terms = array_merge($terms, $locs);
            
            $cases = $cases->where(function($q) use ($terms, $fields) {
                         foreach($terms as $term) {
                            foreach($fields as $field) {
                               $q->orWhere($field, 'LIKE', '%'.$term.'%'); 
                            }   
                        }
                      });
            
            if (isset($dates)) {
            }
            
            if (isset($remote)) {
                $cases = $cases->where('remote',$remote);
            }
            
            $cases = $cases->where('status',1);
        }
        
        $res = $cases->get();
        $dd = DB::getQueryLog();
        
        $results['count'] = $cases->count();
        
        $checkSchool = (is_null($user)) ? false : true;
        $sid = 0;
        if ($checkSchool) { $sid = $user->organization_id; }
        
        foreach($res as $j) {
                $item = [
                            'id'=> $j->id,
                            'title'=>$j->title,
                            'teaser'=>$j->teaser,
                            'description_text'=>$j->description_text,
                            'orgname'=>$j->orgname,
                            'orglogo'=>$j->orglogo,
                            'country'=>$j->country,
                            'city'=>$j->city,
                            'featured'=>$j->featured,
                            'post_date'=>$j->created_at,
                            'jobTypes'=>$j->job_types,
                            'questionnaire_id'=>$j->questionnaire_id,
                            'preselect'=>$j->preselect,
                         ];
                array_push($results['all'], $item);
            
                if ($checkSchool && $sid>0) {
                    if (in_array($sid, explode(',',$j->school_ids))) {
                        array_push($results['school'], $item);   
                    }
                }
            
                if ($j->featured) { array_push($results['featured'], $item);}
        }
        
        //$results['dd'] = $dd;
        return $results;
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
