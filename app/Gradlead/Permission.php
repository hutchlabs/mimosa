<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'system_permissions';

    protected $guarded = [];

    protected $hidden = [];

    public function organization()
    {
        return $this->hasOne('\App\Gradlead\Organization');
    }

    public function hasPreSelect() { return $this->preselect==1; }
    public function hasScreening() { return $this->screening==1; }
    public function hasTracking() { return $this->tracking==1; }
    public function hasBadges() { return $this->badges==1; }
    public function hasEvents() { return $this->events==1; }
}
