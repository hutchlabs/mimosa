<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'jobs_applications';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['job','resume'];

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
        return $this->hasOne('\App\Gradlead\Resume');
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
