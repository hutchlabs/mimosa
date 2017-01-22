<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['contract'];

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

    public function scopeWhereFeatured($query) {
        return $query->whereHas('contract.plan', function($q) {
    		    $q->where('feature_job', '=', '1');
        });
    }

    public static function featured()
    {
		return Job::with('organization')->WhereFeatured()->get();
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
