<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Gradlead\Questionnaire;
use App\Gradlead\Question;
use App\Gradlead\QuestionField;

class QuestionnaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Questions
    public function showQuestions()
    {
        $items = Question::all();
        return $this->json_response($items);
    }
    
    public function storeQuestion(Request $request)
    {
      $user = $request->user();
        
       $this->validate($request, [
           'questionnaire_id'=> 'required|exists:questionnaires,id',
           'caption' => 'required|max:255',
           'type' => 'required|in:string,boolean,multilist,list',
           'yes_score' => 'required_if:type,boolean',
           'no_score' => 'required_if:type,boolean',
           'la_one' => 'required_if:type,multilist|required_if:type,list|nullable',
           'la_two' => 'required_if:type,multilist|required_if:type,list|nullable',
           'la_three' => 'required_if:type,multilist|required_if:type,list|nullable',

        ]
        );

        $i = new Question();
        $i->questionnaire_id = $request->questionnaire_id;
        $i->caption = $request->caption;
        $i->is_required = (isset($request->is_required) && $request->is_required=='on') ? true : false;
        $i->max_length = 10;
        $i->type = $request->type;
        $i->order = Question::getNextPosition($request->questionnaire_id);
        $i->modified_by = $user->id;
        $i->save();
        
        $this->addFields($i, $request, $user->id);
        
        return $this->json_response($i);
    }

    public function updateQuestion(Request $request, $itemId)
    {
       $user = $request->user();
        
       $this->validate($request, [
           'id' => 'required|exists:questions,id',
           'questionnaire_id'=> 'required|exists:questionnaires,id',
           'caption' => 'required|max:255',
           'type' => 'required|in:string,boolean,multilist,list',
           'yes_score' => 'required_if:type,boolean',
           'no_score' => 'required_if:type,boolean',
           'la_one' => 'required_if:type,multilist|required_if:type,list|nullable',
           'la_two' => 'required_if:type,multilist|required_if:type,list|nullable',
           'la_three' => 'required_if:type,multilist|required_if:type,list|nullable',
        ]
        );

        $i = Question::find($request->id);
        $i->questionnaire_id = $request->questionnaire_id;
        $i->caption = $request->caption;
        $i->is_required = (isset($request->is_required) && $request->is_required=='on') ? true : false;
        $i->max_length = 10;
        $i->type = $request->type;
        $i->modified_by = $user->id;
        $i->save();
        
        $this->addFields($i, $request, $user->id);
        
        return $this->json_response($i);
    }
    
    protected function addFields($q, $request, $uid) {
        $q->removeFields();
        
        if ($q->type=='boolean') {
            $fields = [
                ['question_id'=>$q->id,'order'=>1,'value'=>'bYes','score'=>$request->yes_score,
                'modified_by'=>$uid],
                ['question_id'=>$q->id,'order'=>2,'value'=>'bNo','score'=>$request->no_score,
                'modified_by'=>$uid],
            ];
            QuestionField::insert($fields);
            
        } elseif ($q->type=='multilist' || $q->type=='list') {
            $fields = [];
            $order = 1;
            
            if ($request->la_one<>'') {
                array_push($fields, [
                        'question_id'=>$q->id,
                        'order'=>$order,
                        'value'=> $request->la_one,
                        'score'=> $request->ls_one,
                        'modified_by'=>$uid
                    ]);
                $order++;
            }
            
            if ($request->la_two<>'') {
                array_push($fields, [
                        'question_id'=>$q->id,
                        'order'=>$order,
                        'value'=> $request->la_two,
                        'score'=> $request->ls_two,
                        'modified_by'=>$uid
                ]);
                $order++;
            }
                       
            if ($request->la_three<>'') {
                array_push($fields, [
                        'question_id'=>$q->id,
                        'order'=>$order,
                        'value'=> $request->la_three,
                        'score'=> $request->ls_three,
                        'modified_by'=>$uid
                ]);
                $order++;
            }
            
            if (sizeof($fields)) {
                QuestionField::insert($fields);
            } else {
                QuestionField::insert(['question_id'=>$q->id,'order'=>1,
                                       'value'=>'Select any', 'score'=>4, 'modified_by'=>$uid]);
            }
        }
    }

    public function destroyQuestion(Request $request, $itemId)
    {
        $i = Question::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find Question'], true);
        } else {
            $i->remove();
            return $this->ok();
        }
    }
    
    
    // Questionnaires
    public function index()
    {
        $items = Questionnaire::all();
        return $this->json_response($items);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
           'name' => 'required|max:255',
           'passing_score' => 'required|numeric',
           'email_more'=> 'required_if:send_auto_reply_more,on|nullable',
           'email_less'=> 'required_if:send_auto_reply_less,on|nullable',
          ]
        );

        // 1. Create Questionnaire
        $i = new Questionnaire();
        $i->name = $request->name;
        $i->passing_score = $request->passing_score;
        $i->send_auto_reply_more = (isset($request->send_auto_reply_more) && $request->send_auto_reply_more=='on') ? true : false;
        $i->send_auto_reply_less = (isset($request->send_auto_reply_less) && $request->send_auto_reply_less=='on') ? true : false;
        $i->email_more = (isset($request->email_more)) ? $request->email_more : '';
        $i->email_less = (isset($request->email_less)) ? $request->email_less : '';
        $i->modified_by = $user->id;
        $i->save();
        
        return $this->json_response($i);
    }

    public function update(Request $request, $itemId)
    {
       $user = $request->user();
        
        $this->validate($request, [
           'id' => 'required|exists:questionnaires,id',
           'name' => 'required|max:255',
           'passing_score' => 'required|numeric',
           'email_more'=> 'required_if:send_auto_reply_more,on|nullable',
           'email_less'=> 'required_if:send_auto_reply_less,on|nullable',
          ]
        );

        // 1. Create Questionnaire
        $i = Questionnaire::find($request->id);
        $i->name = $request->name;
        $i->passing_score = $request->passing_score;
        $i->send_auto_reply_more = (isset($request->send_auto_reply_more) && $request->send_auto_reply_more=='on') ? true : false;
        $i->send_auto_reply_less = (isset($request->send_auto_reply_less) && $request->send_auto_reply_less=='on') ? true : false;
        $i->email_more = (isset($request->email_more)) ? $request->email_more : '';
        $i->email_less = (isset($request->email_less)) ? $request->email_less : '';
        $i->modified_by = $user->id;
        $i->save();
        
        return $this->json_response($i);
    }

    public function destroy(Request $request, $itemId)
    {
        $i = Questionnaire::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find Questionnaire'], true);
        } else {
            $i->removeQuestions();
            $i->delete();
            return $this->ok();
        }
    }
}
