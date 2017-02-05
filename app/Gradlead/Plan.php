<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';

    protected $guarded = [];

    protected $hidden = [];
    
    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['expired']);
        return parent::getArrayableAppends();
    }

    public function getExpiredAttribute() 
    {
      return $this->isExpired();
    }
    
    
    public function contracts()
    {
        return $this->hasMany('\App\Gradlead\Contract', 'plan_id', 'id');
    }
    
    public function scopeNotExpired($query) 
    {
        return $query->whereRaw("NOW() BETWEEN start_date AND end_date")->get();
    }
    
    public function isExpired()
    {
        return (strtotime($this->end_date) < strtotime(date('Y-m-d')));
    }
}
