<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles_users';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['preference','skill','resumes','education','languages','experiences'];

    public function preference()
    {
        return $this->hasOne('\App\Gradlead\ProfileStudentPreference', 'user_id', 'user_id');
    }

    public function skill()
    {
        return $this->hasOne('\App\Gradlead\ProfileStudentSkill', 'user_id', 'user_id');
    }

    public function resumes()
    {
        return $this->hasMany('\App\Gradlead\ProfileStudentResume', 'user_id', 'user_id');
    }

    public function education()
    {
        return $this->hasMany('\App\Gradlead\ProfileStudentEducation', 'user_id', 'user_id');
    }

    public function languages()
    {
        return $this->hasMany('\App\Gradlead\ProfileStudentLanguage', 'user_id', 'user_id');
    }

    public function experiences()
    {
        return $this->hasMany('\App\Gradlead\ProfileStudentExperience', 'user_id', 'user_id');
    }
}
