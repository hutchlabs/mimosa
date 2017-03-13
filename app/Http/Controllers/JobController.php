<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Gradlead\Job;
use App\Gradlead\Application;
use App\Gradlead\Contract;


class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>'featured']);
        $this->middleware('tenant');
    }
    
    public function applications(Request $request)
    {
        $items = Application::all();
        return $this->json_response($items);
    }
    
    public function apply(Request $request)
    {
        $user = $request->user();
        
        $this->validate($request, [
           'job_id' => 'required|exists:jobs,id',
           'user_id' => 'required|exists:users,id',
           'resume_id' => 'present'
          ]
        );
        
        if (Application::isDuplicate($request->job_id, $request->user_id)) {
            return $this->json_response(['You have already applied to this job'],true,422);
        }
        
        $j = Job::find($request->job_id);
        $u = User::find($request->user_id);

        // 1. Create Application
        $i = new Application();
        $i->job_id = $request->job_id;
        $i->user_id = $request->user_id;
        $i->resume_id = $request->resume_id;
        
        $i->preselect_pass = (is_null($j->preselect)) ? null : $j->doPreselectEvaluation($u);
    
        if ($j->questionnaire_id > 0) {
            $i->screening =  (isset($request->screening) && sizeof($request->screening)>0) 
                          ? json_encode($request->screening) : null;
            $i->screening_score = $j->doScreeningEvaluation($request->screeening);
        }
        
        $i->status = (!is_null($this->preselect_pass) && $i->preselect_pass==0) ? 'Rejected' : 'Pending';
        
        $i->modified_by = $user->id;
        $i->save();
        
        return $this->json_response($i);
    }
   
    public function updateAppStatus(Request $request, $appId, $status)
    {
        $user = $request->user();
        $a = Application::find($appId);
        if ($a) {
            $a->status = $status;
            $a->save();
        }
        return $this->ok();
    }
    
    public function updateApplication(Request $request)
    {
        $user = $request->user();
        
        $this->validate($request, [
           'application_id' => 'required|exists:jobs_applications,id',
           'status' => 'required|in:Pending,Rejected,Approved,Interviewed,Hired,Failed'
          ]
        );
        
        $a = Application::find($request->application_id);
        $a->status = $request->status;
        $a->save();
        
        return $this->ok();
    }
    
    public function unapply(Request $request, $itemId)
    {
        $i = Application::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find application'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
    
    #-- Jobs --
    
    public function index()
    {
        $tenant = $this->getTenant();
        $items = ($tenant->isGradlead()) ? Job::all() : Job::myJobs($tenant->id);
        return $this->json_response($items);
    }

    public function featured()
    {
        $items = Job::featuredJobs();
        return $this->json_response($items);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();

        // TODO: validation on text/pdf
        $this->validate($request, [
           'organization_id' => 'required|exists:organizations,id',
           'plan_id' => 'required|exists:plans,id',
           'school_ids' => 'required',
           'title'=> 'required|max:255',
           'teaser' => 'required|max:255',
           'description_text' => 'required',
           'pdf' => 'nullable',
           'start_date' => 'present',
           'end_date' =>'present'
          ]
        );
    
        // Validate contract
        if(($contract_id = Contract::checkContract($request->organization_id, $request->plan_id, $user->id))!==false) {
             // 1. Create Job
            $i = new Job();
            $i->organization_id = $request->organization_id;
            $i->contract_id = $contract_id;
            $i->school_ids = $request->school_ids;
            $i->title = $request->title;
            $i->teaser= $request->teaser;

            if ($request->description_text<>'') {
                $i->description_text = $request->description_text;
            } else {
                $fInfo = $this->handleFileUpload($request, 'pdf', 'files/jobs/');
                $i->file_name = $fInfo['name'];
                $i->file_path = $fInfo['path'];
                $i->file_url = $fInfo['url'];
            }

            $i->job_types = (isset($request->job_types)) ?$request->job_types:'';
            $i->positions = (isset($request->positions)) ?$request->positions:'';
            $i->country = (isset($request->country)) ? $request->country:'';
            $i->city = (isset($request->city)) ? $request->city:'';
            $i->remote = (isset($request->remote) && $request->remote=='on') ? 1: 0;
            $i->send_via_email = (isset($request->send_via_email)) ? $request->send_via_email:'';
            $i->send_via_url = (isset($request->send_via_url)) ? $request->send_via_url:'';
            $i->video_title = (isset($request->video_title)) ? $request->video_title:'';
            $i->video_url = (isset($request->video_url)) ? $request->video_url:'';

            $i->preselect = (isset($request->preselect) && sizeof($request->preselect)>0) ? $request->preselect:'';
            $i->questionnaire_id = ($request->questionnaire_id=='') ? 0 : $request->questionnaire_id;

            $i->start_date = date("Y-m-d", strtotime($request->start_date));
            $i->end_date = date("Y-m-d", strtotime($request->end_date));
            
            //TODO: task to check feature status
            $i->featured = ($this->getTenant()->isGradlead()) 
                         ? ((isset($request->featured)) ? 1:0) : $i->getFeaturedStatus();
            
            //TODO: task to check and change job status
            $i->setStatus();
            
            $i->modified_by = $user->id;
            $i->save();

            // TODO: notify alerts
            return $this->json_response($i);
        } else {
            return $this->json_response(['Invalid contract'], true, 422);
        }
    }

    public function update(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
           'organization_id' => 'required|exists:organizations,id',
           'plan_id' => 'required|exists:plans,id',
           'school_ids' => 'required',
           'title'=> 'required|max:255',
           'teaser' => 'required|max:255',
           'description_text' => 'required',
           'start_date' => 'present',
           'end_date' =>'present'
          ]
        );

        $i = Job::find($itemId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find job to update'], true);    
        }
        
        $i->organization_id = $request->organization_id;
        $i->school_ids = $request->school_ids;
        $i->title = $request->title;
        $i->teaser= $request->teaser;
        
        if ($request->description_text<>'') {
            $i->description_text = $request->description_text;
        } else {
            $fInfo = $this->handleFileUpload($request, 'pdf', 'files/jobs/');
            $i->file_name = $fInfo['name'];
            $i->file_path = $fInfo['path'];
            $i->file_url = $fInfo['url'];
        }
        
        $i->job_types = (isset($request->job_types)) ?$request->job_types:'';
        $i->positions = (isset($request->positions)) ?$request->positions:'';
        $i->country = (isset($request->country)) ? $request->country:'';
        $i->city = (isset($request->city)) ? $request->city:'';
        $i->remote = (isset($request->remote) && $request->remote=='on') ? 1: 0;

        $i->send_via_email = (isset($request->send_via_email)) ? $request->send_via_email:'';
        $i->send_via_url = (isset($request->send_via_url)) ? $request->send_via_url:'';
        $i->video_title = (isset($request->video_title)) ? $request->video_title:'';
        $i->video_url = (isset($request->video_url)) ? $request->video_url:'';
        
        $i->preselect = (isset($request->preselect) && sizeof($request->preselect)>0) ? $request->preselect:'';
        $i->questionnaire_id = ($request->questionnaire_id=='') ? 0 : $request->questionnaire_id;
       
        $i->start_date = date("Y-m-d", strtotime($request->start_date));
        $i->end_date = date("Y-m-d", strtotime($request->end_date));
        
        $i->setStatus();
        $i->featured = ($this->getTenant()->isGradlead()) ? ((isset($request->featured)) ? 1:0) : $i->getFeaturedStatus();
        
        $i->modified_by = $user->id;
        $i->save();
        
        return $this->json_response($i);
    }
    
    public function updateStatus(Request $request, $itemId)
    {
        $user = $request->user();

        $i = Job::find($itemId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find job to update'], true);    
        }
        
        $i->status = !$i->status;        
        $i->modified_by = $user->id;
        $i->save();
        
        return $this->json_response($i);
    }
    
    public function updateFeature(Request $request, $itemId)
    {
        $user = $request->user();

        $i = Job::find($itemId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find job to update'], true);    
        }
        
        $i->featured = !$i->featured;        
        $i->modified_by = $user->id;
        $i->save();
        
        return $this->json_response($i);
    }

    public function destroy(Request $request, $itemId)
    {
        $i = Job::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find Job'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
}
