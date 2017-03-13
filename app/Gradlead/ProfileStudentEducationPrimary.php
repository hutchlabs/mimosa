<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class ProfileStudentEducationPrimary extends Model
{
    protected $table = 'profiles_student_education_primary';

    protected $guarded = [];

    protected $hidden = [];
    
    protected function getArrayableAppends()
    {
        $appends = ['graduation'];        
        $this->appends = array_merge($this->appends, $appends);
        return parent::getArrayableAppends();
    }
    
    public function getGraduationAttribute() 
    {
        $monthName = date('F', mktime(0, 0, 0, $this->graduation_month, 10));
        return $monthName.', '.$this->graduation_year;
    }
}
