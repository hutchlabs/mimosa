<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use HipsterJazzbo\Landlord\BelongsToTenants;

class User extends Authenticatable
{
    use Notifiable, BelongsToTenants;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = ['role','organization'];

    public function role()
    {
        return $this->hasOne('\App\Gradlead\Role', 'id', 'role_id');
    }

    public function organization()
    {
        return $this->belongsTo('\App\Gradlead\Organization');
    }

    public function isSuperAdmin() 
    {
        return $this->role->name == 'Super Administrator'; 
    }
}
