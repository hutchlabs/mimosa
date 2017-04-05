<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Gradlead\Permission;
use App\Gradlead\Contract;
use App\Gradlead\Theme;
use App\Gradlead\Template;
use App\Gradlead\ProfileCompany;
use App\Gradlead\Affiliation;

class Organization extends Model
{
    protected $table = 'organizations';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['contracts','events','jobs','permissions'];

    protected function getArrayableAppends()
    {
        $appends = ['logo_url','profile','numusers','numschools','numrecruiters','templates','theme'];
        
        if ($this->isCompany()) { array_push($appends,'schools'); } 
        
        $this->appends = array_merge($this->appends, $appends);

        return parent::getArrayableAppends();
    }

    public function getThemeAttribute() 
    {
      // Create new theme for organization based on Gradlead default
      $theme =  DB::table('themes')->select(DB::raw('*'))->where('organization_id',$this->id)->first(); 
      if (is_null($theme)) {
        $request =  DB::table('themes')->select(DB::raw('*'))->where('organization_id',1)->first(); 
        $i = new Theme();
        $i->home_header = $request->home_header;
        $i->partners_header = $request->partners_header;
        $i->contact_header = $request->contact_header;
        $i->home_first_title = $request->home_first_title;
        $i->home_second_title = $request->home_second_title;
        $i->home_third_title = $request->home_third_title;
        $i->home_first = $request->home_first;
        $i->home_second = $request->home_second;
        $i->home_third = $request->home_third;
        $i->partners_first_title = $request->partners_first_title;
        $i->partners_second_title = $request->partners_second_title;
        $i->partners_third_title = $request->partners_third_title;
        $i->partners_first = $request->partners_first;
        $i->partners_second = $request->partners_second;
        $i->contact_first_title = $request->contact_first_title;
        $i->contact_second_title = $request->contact_second_title;
        $i->contact_third_title = $request->contact_third_title;
        $i->contact_first = $request->contact_first;
        $i->contact_second = $request->contact_second;
        $i->contact_third = $request->contact_third;
        $i->home_hero = $request->home_hero;
        $i->partners_hero = $request->partners_hero;
        $i->contact_hero = $request->contact_hero;
        $i->organization_id = $this->id;
        $i->modified_by = 1;
        $i->save();
        $theme = $i;
      }
      return $theme;
    }
    
    public function getTemplatesAttribute() 
    {
        // Create new theme for organization based on Gradlead default
        $tpls =  DB::table('templates')->select(DB::raw('*'))->where('organization_id',$this->id)->get(); 
        $defs =  DB::table('templates')->select(DB::raw('*'))->where('organization_id',1)->get(); 

        if (is_null($tpls) or sizeof($tpls)==0) {
            foreach($defs as $def) {
              
              $i = new Template();
              $i->organization_id = $this->id;
              $i->name = $def->name;
              $i->type = $def->type;
              $i->description = $def->description;
              $i->template = $def->template;
              $i->system = $def->system;
              $i->modified_by = 1;
              $i->save();
              $tpls[strtolower(preg_replace('/ /','_',$i->name))] = $i;
            }
        } else {
            foreach($tpls as $key => $tp) {
                $tpls[strtolower(preg_replace('/ /','_',$tp->name))] = $tp;
                unset($tpls[$key]);
            }
        }
        return $tpls;
    }

    public function getNumusersAttribute() 
    {
      return DB::table('users')
                ->select(DB::raw('id'))
                ->where('organization_id',$this->id)
                ->count(); 
    }

    public function getSchoolsAttribute() {
      return DB::table('organizations_employers')
                ->select(DB::raw('organization_id'))
                ->where('employer_id',$this->id)
                ->get()->pluck('organization_id'); 
    }

    public function getNumschoolsAttribute() {
      return DB::table('organizations_employers')
                ->select(DB::raw('id'))
                ->where('employer_id',$this->id)
                ->count(); 
    }

    public function getNumrecruitersAttribute() {
      return DB::table('organizations_employers')
                ->select(DB::raw('id'))
                ->where('organization_id',$this->id)
                ->count(); 
    }

    public function getProfileAttribute()
    {
        $profile = null;
        if ($this->isSchool() || $this->isGradlead()) {
            $profile = DB::table('profiles_schools')->select(DB::raw('*'))->where('organization_id',$this->id)->first(); 
            if (is_null($profile)) {
                $profile = new ProfileSchool();
                $profile->organization_id = $this->id;
                $profile->summary = "This is the default profile text. Please update your profile.";
                $profile->modified_by = 1;
                $profile->save();
            }
        } else {
            $profile = DB::table('profiles_companies')->select(DB::raw('*'))
                                ->where('organization_id',$this->id)->first(); 
            if (is_null($profile)) {
                $profile = new ProfileCompany();
                $profile->organization_id = $this->id;
                $profile->summary = "This is the default profile text. Please update your profile.";
                $profile->modified_by = 1;
                $profile->save();
            }
        }
                
        $address = [];
        if ($profile->street<>'') { array_push($address, $profile->street); }
        if ($profile->neighborhood<>'') { array_push($address, $profile->neighborhood); }
        if ($profile->city<>'') { array_push($address, $profile->city); }
        if ($profile->country<>'') { array_push($address, $profile->country); }
        $profile->address = (sizeof($address)>0) ? join(', ',$address) : 'No address given';
        return $profile;
    }
    
    public function getLogourlAttribute() 
    {
        $logo = 'img/a0.jpg';
        $path = ($this->isSchool() || $this->isGradlead()) ? 'crest' : 'logo';
        if (!is_null($this->profile) && $this->profile->file_name<>'') {
            $logo = '/profiles/'.$path.'/'.$this->profile->id.'?'.date('Y-m-d');
        }
        return $logo;
    }

    public function mytheme()
    {
         return $this->hasOne('\App\Gradlead\Theme', 'organization_id', 'id');
    }

    public function permissions()
    {
         return $this->hasOne('\App\Gradlead\Permission', 'organization_id', 'id');
    }

    public function contracts() 
    {
        return $this->hasMany('\App\Gradlead\Contract');
    }    

    public function users() 
    {
        return $this->hasMany('\App\User');
    } 
    
    public function jobs() 
    {
        return $this->hasMany('\App\Gradlead\Job');
    }   
    
    public function events() 
    {
        return $this->hasMany('\App\Gradlead\Event');
    } 

    public function schools() 
    {
        return $this->belongsToMany('\App\Gradlead\Organization','organizations_employers','employer_id','organization_id');
    }    
    
    public function companies() 
    {
        return $this->belongsToMany('\App\Gradlead\Organization','organizations_employers','organization_id','employer_id');
    }  

    public static function scopeEmployers($query)
    {
        return $query->where('type','employer')->get();
    }

    public static function featured()
    {
		return Organization::whereHas('contracts.plan', function($query) {
    		$query->where('feature_company', '=', '1');
        })->get();
    }

    public static function updateApprovalStatus($approvalId, $userId)
    {
        $i = DB::table('organizations_employers')->select(DB::raw('approved'))->where('id',$approvalId)->first();
        if (!is_null($i)) {
            $i->approved = ! $i->approved;
            $i->modified_by = $userId;
            $i->save();
            return true;
        }
        return false;
    }
    
    public function removeAffiliationFromSchool($schoolId)
    {
        $i = DB::table('organizations_employers')
                ->select(DB::raw('id'))
                ->where('organization_id',$schoolId)
                ->where('employer_id',$this->id)->first();
        
        if (!is_null($i)) {
            $i = Affiliation::find($i->id);
            $i->delete();
            return true;
        }
        return false;
    }
    
      
    public function removeAffiliationFromEmployer($empId)
    {
        $i = DB::table('organizations_employers')
                ->select(DB::raw('id'))
                ->where('organization_id',$this->id)
                ->where('employer_id',$empId)->first();
        
        if (!is_null($i)) {
            $i = Affiliation::find($i->id);
            $i->delete();
            return true;
        }
        return false;
    }
    
    
    public static function search($keywords, $loc, $type='employer', $dates=null, $remote=null)
    {   
        //DB::enableQueryLog();      
        $results = ['count'=>0, 'all'=>[]];
           
        $orgCases = Organization::query();
        $pcCases = ProfileCompany::query();
        
        $orgFields = ['name'];
        $pcFields = ['summary','description','street',
                     'job_types', 'country','city','industries','neighborhood'];

        if ($keywords <> '' || $loc <> '') {
            $terms = explode(' ', trim($keywords));
            $locs = explode(' ', trim($loc));
            $terms = array_merge($terms, $locs);
            
            foreach($terms as $key=>$val) { if ($val==''){ unset($terms[$key]); }}

            $pcCases = $pcCases->where(function($q) use ($terms, $pcFields) {
                         foreach($terms as $term) {
                            foreach($pcFields as $field) {
                               $q->orWhere($field, 'LIKE', '%'.$term.'%'); 
                            }   
                        }
                      });
            
            $orgCases = $orgCases->where(function($q) use ($terms, $orgFields) {
                         foreach($terms as $term) {
                            foreach($orgFields as $field) {
                               $q->orWhere($field, 'LIKE', '%'.$term.'%'); 
                            }   
                        }
                      });
            
            if (isset($dates)) { }
            
            //$cases = $cases->where('status',1);
        }
        //$dd = DB::getQueryLog();
        //$results['dd'] = $dd;

        $seen = [];
        
        $res = $pcCases->get();

        foreach($res as $j) {
            if (!in_array($j->organization_id,$seen)) {
                $item = Organization::find($j->organization_id);            
                if($item->type==$type) { array_push($results['all'], $item); }
                array_push($seen, $j->organization_id);
            }
        }
        
        $res = $orgCases->get();
        foreach($res as $j) {
            if (!in_array($j->id,$seen)) {
                if ($j->type==$type) { array_push($results['all'], $j); }
                array_push($seen, $j->id);
            }
        }
        
        $results['count'] = sizeof($results['all']);

        return $results;
    }
    
    
    public function isSchool() 
    {
        return ($this->type=='school') ? true : false;
    }

    public function isCompany() 
    {
        return ($this->type=='employer');
    }

    public function isGradlead() 
    {
        return ($this->type=='gradlead');
    }
    
    public function cleanUp()
    {
        $this->permissions()->detach();
        $this->events()->detach();
        $this->profile()->detach();
        $this->jobs()->detach();
        $this->contracts()->detach();
    }
}
