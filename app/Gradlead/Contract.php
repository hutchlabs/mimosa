<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'plans_contracts';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['plan'];

    public function plan()
    {
        return $this->hasOne('\App\Gradlead\Plan', 'plan_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo('\App\Gradlead\Organization');
    }
    
    public function scopeNotExpired($query) 
    {
        return $query->whereRaw("NOW() BETWEEN start_date AND end_date")->get();
    }
    
    public function isValid()
    {
        return ((strtotime($this->end_date) > strtotime()) &&
                (strtotime() >= strtotime($this->start_date)));
    }
    
    public static function checkContract($orgId, $planId)
    {         
        $c = Contract::whereRaw('organization_id=? and plan_id=? and NOW() BETWEEN start_date AND end_date',
                                array($orgId,$planId))->first();
     
        if (is_null($c)) {
            $p = Plan::find($planId);
            
            if (is_null($p)) { return false; }
            
            $c = new Contract();
            $c->organization_id = $orgId;
            $c->plan_id = $planId;
            $c->remaining_posts = $p->num_posts - 1;
            $c->remaining_notifications = $p->num_notifications;
            $c->start_date = date('Y-m-d');
            $c->end_date = date('Y-m-d',strtotime($c->start_date,"+ ".$p->duration." days"));
        
            //TODO: handle featured options
        
        } else {
            if ($c->remaining_posts>0) { $c->remaining_posts--; }
            if ($c->remaining_notifications>0) {
                // TODO: implement notifications
                $c->remaining_notifications = 0;
            }
        }
        
        $c->save();

        return $c->id;
    }
}
