<?php

namespace App\Gradlead;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'jobs_applications';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['resume'];
    
    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['applicant','jobname','orgname']);
        return parent::getArrayableAppends();
    }

    public function getApplicantAttribute() 
    {
        $user = DB::table('users')
                ->select(DB::raw("CONCAT(first,' ',last) as name"))
                ->where('id',$this->user_id)
                ->first(); 
        return $user->name;
    }
    
    public function getJobnameAttribute() 
    {
        $job = DB::table('jobs')
                ->select(DB::raw('title'))
                ->where('id',$this->job_id)
                ->first(); 
        return $job->title;
    }
    
    public function getOrgnameAttribute() 
    {
        $job = DB::table('jobs')
                ->select(DB::raw('organization_id'))
                ->where('id',$this->job_id)
                ->first(); 
        if ($job) {
            $org = DB::table('organizations')
                ->select(DB::raw('name'))
                ->where('id',$job->organization_id)
                ->first();
            return ($org) ? $org->name : "";
        }
        return "";
    }



    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function job()
    {
        return $this->belongsTo('\App\Gradlead\Job');
    }

    public function resume()
    {
        return $this->belongsTo('\App\Gradlead\ProfileStudentResume');
    }
    
    public static function isDuplicate($jobId, $userId) 
    {
      return DB::table($this->table)
                ->select(DB::raw('id'))
                ->where('job_id',$jobId)
                ->where('user_id',$userId)
                ->count() > 0;    
    }
}
