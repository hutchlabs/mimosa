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

    protected $with = ['role','organization','profile','bookmarks','alerts',
                       'address','achievements','applications'];

    public function role()
    {
        return $this->hasOne('\App\Gradlead\Role', 'id', 'role_id');
    }

    public function organization()
    {
        return $this->belongsTo('\App\Gradlead\Organization');
    }

    public function profile()
    {
        return $this->hasOne('\App\Gradlead\Profile', 'user_id', 'id');
    }

    public function alerts()
    {
        return $this->hasMany('\App\Gradlead\Alert', 'user_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('\App\Gradlead\Address', 'user_id', 'id');
    }
    
    public function applications()
    {
        return $this->hasMany('\App\Gradlead\Application', 'user_id', 'id');
    }

    public function achievements()
    {
        return $this->hasMany('\App\Gradlead\Achievement', 'user_id', 'id');
    }

    public function bookmarks()
    {
        return $this->hasMany('\App\Gradlead\Bookmark', 'user_id', 'id');
    }
    
    public static function scopeCandidates($query) 
    {
        return $query->whereRaw('user_type in ("student","graduate")')->get();
    }

    public function isSuperAdmin() 
    {
        return $this->role->name == 'Super Administrator'; 
    }
    
    public function isStudent() 
    {
        return in_array($this->type, array('student','graduate')); 
    }
    
    public function cleanUp()
    {
        $this->address()->detach();
        $this->alerts()->detach();
        $this->achievements()->detach();
        $this->applications()->detach();
        $this->bookmarks()->detach();
        $this->profile()->detach();
    }
}
