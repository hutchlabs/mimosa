<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Badge extends Model
{
    protected $table = 'badges';

    protected $guarded = [];

    protected $hidden = [];

    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['numachievements']);
        return parent::getArrayableAppends();
    }

    public function getNumachievementsAttribute() {
        return DB::table('users_achievements')->select(DB::raw('id'))->where('badge_id',$this->id)->count(); 
    }
    
    public function removeAchievements()
    {
        //TODO: Remove achievements
    }
}
