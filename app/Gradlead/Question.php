<?php

namespace App\Gradlead;

use App\Gradlead\BaseModel;

class Question extends BaseModel
{
    protected $table = 'question';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['fields'];

    public function questionnaire()
    {
        return $this->belongsTo('\App\Gradlead\Questionnaire');
    }

    public function fields()
    {
        return $this->hasMany('\App\Gradlead\QuestionField');
    }
}
