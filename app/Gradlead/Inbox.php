<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Gradlead\Organization;

class Inbox extends Model
{
    protected $table = 'users_inbox';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['msgparent'];
       
    protected function getArrayableAppends()
    {
        $appends = ['to','from'];        
        $this->appends = array_merge($this->appends, $appends);
        return parent::getArrayableAppends();
    }
    
    protected function getToAttribute()
    {
        $x = DB::table('users')
            ->select(DB::raw('id,organization_id,first,last,uuid,type,email'))
            ->where('id',$this->user_id)
            ->first(); 
        $x->name = $x->first.' '.$x->last;
        
        $org = Organization::find($x->organization_id);
        $x->orgname = $org->name;
        $x->orgurl = $org->logo_url;
        $x->avatar = '/profiles/avatar/2?'.date('ymd');
        
        return $x;
    }
    
    protected function getFromAttribute()
    {
        $x = DB::table('users')
            ->select(DB::raw('id,organization_id,first,last,uuid,type,email'))
            ->where('id',$this->from_id)
            ->first(); 
        $x->name = $x->first.' '.$x->last;
        
        $org = Organization::find($x->organization_id);
        $x->orgname = $org->name;
        $x->orgurl = $org->logo_url;
        $x->avatar = '/profiles/avatar/2?'.date('ymd');
        
        return $x;
    }
    
    public function user() 
    {
        return $this->belongsTo('\App\User');
    }

    public function sender() 
    {
        return $this->belongsTo('\App\User','from_id');
    }

    public function msgparent() 
    {
        return $this->belongsTo('\App\Gradlead\Inbox','response_to');
    }
    
    public function markTrash($user) 
    {
        $i->seen = 2;
        $i->modified_by = $user->id;
        $i->save();
    }
    
    public function markRead($user) 
    {
        $i->seen = 1;
        $i->modified_by = $user->id;
        $i->save();
    }
    
    public function remove()
    {
        $msgs = \App\Gradlead\Inbox::where('response_to',$this->id)->get();
        foreach($msgs as $m) { $m->remove(); }
        $this->del();
    }
    
    private function del()
    {
        $this->delete();
    }
}
