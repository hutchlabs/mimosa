<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Gradlead\Permission;

class Organization extends Model
{
    protected $table = 'organizations';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['profile','contracts','jobs','permissions','events'];

    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['numusers','numschools','numrecruiters']);
        return parent::getArrayableAppends();
    }

    public function getNumusersAttribute() {
      return DB::table('users')
                ->select(DB::raw('id'))
                ->where('organization_id',$this->id)
                ->count(); 
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

    public function profile()
    {
        if ($this->isSchool() || $this->isGradlead()) {
          return $this->hasOne('\App\Gradlead\ProfileSchool', 'organization_id', 'id');
        } else {
          return $this->hasOne('\App\Gradlead\ProfileCompany', 'organization_id', 'id');
        }
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
    
    public function isSchool() 
    {
        return ($this->type=='school');
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
