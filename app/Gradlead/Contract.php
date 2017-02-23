<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use HipsterJazzbo\Landlord\BelongsToTenants;


class Contract extends Model
{
        use BelongsToTenants;

    protected $table = 'plans_contracts';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['plan'];
    
    protected function getArrayableAppends()
    {
        $appends = ['expired'];
        $this->appends = array_merge($this->appends, $appends);
        return parent::getArrayableAppends();
    }

    public function getExpiredAttribute() 
    {
      return (!$this->isValid() || !$this->hasPosts());
    }

    public function plan()
    {
        return $this->belongsTo('\App\Gradlead\Plan');
    }

    public function organization()
    {
        return $this->belongsTo('\App\Gradlead\Organization');
    }
    
    public function scopeExpired($query) 
    {
        return $query->whereRaw("end_date BETWEEN start_date AND NOW()")->get();
    }
    
    public function scopeNotExpired($query) 
    {
        return $query->whereRaw("NOW() BETWEEN start_date AND end_date")->get();
    }

    public function hasPosts()
    {
        return ($this->plan->num_posts==0) ? true : ($this->remaining_posts>0);
    }
    
    public function isValid()
    {
        return ((strtotime($this->end_date) > strtotime(date('Y-m-d'))) && 
                (strtotime(date('Y-m-d')) >= strtotime($this->start_date)));
    }
    
    public static function checkContract($orgId, $planId, $userId)
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
            $c->end_date = date('Y-m-d',strtotime($c->start_date." +".$p->duration." days"));

        } else {
            if ($planId!=1) {
                if ($c->remaining_posts>0) { $c->remaining_posts--; }
            
                if ($c->remaining_notifications>0) {
                    // TODO: implement notifications
                    $c->remaining_notifications = 0;
                }                
            }
        }
        
        $c->modified_by = $userId;
        $c->save();

        Contract::createInvoice($c);
        
        return $c->id;
    }
    
    public static function createInvoice($contract)
    {
        // TODO: handle invoices
    }
}
