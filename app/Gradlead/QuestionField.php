<?php

namespace App\Gradlead;

use App\Gradlead\BaseModel;

class QuestionField extends BaseModel
{
    protected $table = 'questions_fields';

    protected $guarded = [];

    protected $hidden = [];

    public function question()
    {
        return $this->belongsTo('\App\Gradlead\Question');
    }
}
