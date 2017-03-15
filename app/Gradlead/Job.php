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
        $this->appends = array_merge($this->appends, ['numapplications','orgname','orglogo','address','url_public','url_internal']);
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
    
    public function getAddressAttribute()
    {      
        $address = [];
        if ($this->street<>'') { array_push($address, $this->street); }
        if ($this->neighborhood<>'') { array_push($address, $this->neighborhood); }
        if ($this->city<>'') { array_push($address, $this->city); }
        if ($this->country<>'') { array_push($address, $this->country); }
        return (sizeof($address)>0) ? join(', ',$address) : 'No address given';
    }
    
    public function getUrlPublicAttribute()
    {     
        //return $this->doPreselectEvaluation(\App\User::find(10));
        return '/j/'.$this->id; 
    }
    
    public function getUrlInternalAttribute()
    {      
       return  '/home?page=detail&id='.$this->id.'#jobs';
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
        //DB::enableQueryLog();      
        $results = ['count'=>0, 'all'=>[], 'school'=>[], 'other'=>[],'featured'=>[]];
        
        $cases = Job::query();
        
        $fields = ['title','teaser','description_text',
                   'job_types', 'positions','country','city'];
        
        if ($keywords <> '' || $loc <> '') {
            $terms = explode(' ', $keywords);
            $locs = explode(' ', $loc);
            $terms = array_merge($terms, $locs);
            
            foreach($terms as $key=>$val) { if ($val==''){ unset($terms[$key]); }}

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
        //$dd = DB::getQueryLog();
        //dd($dd);exit;
        
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
                            'neighborhood'=>$j->neighborhood,
                            'featured'=>$j->featured,
                            'post_date'=>$j->created_at,
                            'jobTypes'=>$j->job_types,
                            'url_public'=>$j->url_public,
                            'url_internal'=>$j->url_internal,
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
        if(strlen($this->preselect)==1) {
            return null;
        } else {
            $pass = 1;
            $criteria = json_decode($this->preselect);

            list($maxYear, $degrees, $majors) = $this->getEdParts($user->education);

            foreach($criteria as $key => $v) {
                if ($key=='student' && $v=='on') {
                    $pass = ($user->type=='student' && $maxYear >= date('Y')) ? 1:0;
                }

                if ($pass && ($key=='gradyear' && $v!='')) { $pass = ($maxYear == $v) ? 1:0; }

                if ($pass && ($key=='degrees' && $v!='')) {
                    $pass = ($this->hasQual($v, $degrees)) ? 1 : 0;
                }

                if ($pass && ($key=='majors' && $v!='')) {
                    $pass = ($this->hasQual($v, $degrees)) ? 1 : 0;
                }

                if ($pass && ($key=='languages' && $v!='')) {
                    $list = $this->getStringList($user->languages, 'language');
                    $pass = ($this->hasQual($v, $list)) ? 1 : 0;
                }
                
                if ($pass && ($key=='skills' && $v!='')) {
                    $pass = ($this->hasQual($v, $user->skills[0]->skills)) ? 1 : 0;
                }

                if ($pass && ($key=='industries' && $v!='')) {
                    $list = $this->getStringList($user->work, 'industries');
                    $pass = ($this->hasQual($v, $list)) ? 1 : 0;
                } 
            }
            return $pass; 
        }        
    }
    
    private function hasQual($quals, $list) 
    {
        $has = false;
        $qs = explode(',');
        $ls = explode(',');
        foreach($qs as $key => $q) { $qs[$key] = trim($q); }
        foreach($ls as $l) { if (in_array(trim($l), $qs)) { $has = true; }}
        return $has;
    }
    
    private function getEdParts($education) 
    {
        $maxYear = 0;
        $degrees = '';
        $majors = '';
        
        foreach($education as $ed) {
            if ($maxYear < $ed->graduation_year) { $maxYear = $ed->graduation_year; }
            $degrees += ($ed->degree_level=='') ? '' : $ed->degree_level.',';
            $majors += ($ed->degree_major=='') ? '' : $ed->degree_major.',';
        }
        
        $degrees = preg_replace('/,$/','',$degrees);
        $majors = preg_replace('/,$/','',$majors);

        return [$maxYear, $degrees, $majors];
    }
    
    private function getStringList($array, $field)
    {
        $list = '';   
        foreach($array as $item) {
            $list += ($item->$field=='') ? '' : $item->$field.',';
        } 
        $list = preg_replace('/,$/','',$list);
        return $list;
    }
    
    
    public function doScreeningEvaluation($responses)
    {
        $score = 0;
        
        // TODO: score checks
        
        return $score;
    }

}
