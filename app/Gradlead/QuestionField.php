<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;

class QuestionField extends Model
{
    protected $table = 'questions_fields';

    protected $guarded = [];

    protected $hidden = [];

    public function question()
    {
        return $this->belongsTo('\App\Gradlead\Question');
    }
}
