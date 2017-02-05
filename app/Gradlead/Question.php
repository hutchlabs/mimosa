<?php

namespace App\Gradlead;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Question extends Model
{
    protected $table = 'questions';

    protected $guarded = [];

    protected $hidden = [];

    protected $with = ['fields'];

    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['yes_score','no_score','list']);
        return parent::getArrayableAppends();
    }

    public function getYesScoreAttribute() 
    {
        foreach($this->fields as $f) { if ($f->value=='bYes') return $f->score; }
        return 0;
    }
    
    public function getNoScoreAttribute() 
    {
        foreach($this->fields as $f) { if ($f->value=='bNo') return $f->score; }
        return 0;
    }
    
    public function getListAttribute() 
    {
        $answers = [];
        $names = ['lone','ltwo','lthree'];
        
        foreach($names as $n) { $answers[$n] = ['value'=>'','score'=>0]; }
        
        foreach($this->fields as $f) {
              if (!in_array($f->value, array('bYes','bNo'))) {
                  $answers[$names[$f->order-1]] = ['value' => $f->value,'score'=>$f->score];   
              }
        }
        return $answers;
    }
    
    
    public function questionnaire()
    {
        return $this->belongsTo('\App\Gradlead\Questionnaire');
    }

    public function fields()
    {
        return $this->hasMany('\App\Gradlead\QuestionField');
    }
    
    public static function getNextPosition($qnid)
    {
        $i = DB::table('questions')
                ->select(DB::raw('(IFNULL(MAX(`order`),0)+1) as next'))
                ->where('questionnaire_id',$qnid)
                ->first(); 
        return $i->next;
    }
    
    public function remove() 
    {
        $this->removeFields();
        $this->delete();
    }
    
    public function removeFields()
    {
        foreach($this->fields as $f)
        {
            $f->delete();
        } 
    }
}
