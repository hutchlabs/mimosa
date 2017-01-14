<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{
    protected $table = 'organizations';

    protected $guarded = [];

    protected $hidden = [];

    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['numusers','numschools','numrecruiters']);
        return parent::getArrayableAppends();
    }

    public function getNumusersAttribute() {
        return DB::table('users')->select(DB::raw('id'))->where('organization_id',$this->id)->count(); 
    }

    public function getNumschoolsAttribute() {
        return DB::table('organizations_employers')->select(DB::raw('id'))->where('employer_id',$this->id)->count(); 
    }

    public function getNumrecruitersAttribute() {
        return DB::table('organizations_employers')->select(DB::raw('id'))->where('organization_id',$this->id)->count(); 
    }

    public function users() {
        return $this->hasMany('\App\User');
    }    

    public function schools() {
        return $this->belongsToMany('\App\Gradlead\Organization','organizations_employers','employer_id','organization_id');
    }    
    
    public function recruiters() {
        return $this->belongsToMany('\App\Gradlead\Organization','organizations_employers','organization_id','employer_id');
    }  
}
