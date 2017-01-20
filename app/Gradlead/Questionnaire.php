<?php

namespace App\Gradlead;

use App\Gradlead\BaseModel;

class Questionnaire extends BaseModel
{
    protected $table = 'questionnaire';

    protected $guarded = [];

    protected $hidden = [];
    
    protected $with = ['questions']

    public function questions()
    {
        return $this->hasMany('\App\Gradlead\Question');
    }
}
