<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Gradlead\Alert;
use App\Gradlead\Inbox;

class ProcessAlerts implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    protected $alert;
    
    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    public function handle()
    {
        if (count($this->alert->jobs)) {
            $user = User::find($this->alert->user_id);
            
            // get alert templates
            $subject = $this->alert->templates['alerts_subject']->template;
            $contents = $this->alert->templates['alerts']->template;
            $joblist = '';
            
            foreach($this->alert->jobs as $job) {
                $joblist .= "<br/><b>".$job['title'].'</b> from '.$job['orgname'].' [<a href="http://app.gradlead.com'.$job['url_public'].'">link</a>]';
            }
            
            $joblist = ($joblist=='') ? 'No Jobs found' : $joblist;

            $subject = preg_replace('/{{\s*organization\s*}}/',$user->organization->name,$subject);
            $contents = preg_replace('/{{\s*name\s*}}/',$user->name,$contents);
            $contents = preg_replace('/{{\s*organization\s*}}/',$user->organization->name,$contents);
            $contents = preg_replace('/{{\s*content\s*}}/',$joblist,$contents);

            // Create Message
            $msg = new Inbox();
            $msg->user_id = $this->alert->user_id;
            $msg->from_id = 1;
            $msg->response_to = null;
            $msg->subject = $subject;
            $msg->message = $contents;
            $msg->modified_by = 1;
            $msg->save();
            
            // TODO: Email??
        }
        
        $this->alert->updateNextRunDate();
    }
}
