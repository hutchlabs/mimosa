<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class ProfileStudentResume extends Model
{
    protected $table = 'profiles_student_resumes';

    protected $guarded = [];

    protected $hidden = [];
    
    public static function withinLimits($userId)
    {
        return DB::table('profiles_student_resumes')
                ->select(DB::raw('id'))
                ->where('user_id',$userId)
                ->count() < 3;
    }
    
    public static function setDefault($i, $val)
    {
        if ($val==0)
            return true;
        
        DB::update('Update profiles_student_resumes SET default=0 where user_id='.$i->user_id);
        $i->default=1;
        return $i->save();
    }
}
