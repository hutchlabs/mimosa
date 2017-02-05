<?php

namespace App\Gradlead;

use App\Gradlead\BaseModel;
use Illuminate\Support\Facades\DB;


class Questionnaire extends BaseModel
{
    protected $table = 'questionnaires';

    protected $guarded = [];

    protected $hidden = [];
    
    protected $with = ['questions'];

    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['numquestions']);
        return parent::getArrayableAppends();
    }

    public function getNumquestionsAttribute() 
    {
      return DB::table('questions')
                ->select(DB::raw('id'))
                ->where('questionnaire_id',$this->id)
                ->count(); 
    }

    public function questions()
    {
        return $this->hasMany('\App\Gradlead\Question');
    }
    
    public function removeQuestions() 
    {
        foreach($this->questions as $q)
        {
            $q->remove();
        } 
    }
}
