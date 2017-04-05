<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;


class SendWelcomeMessage implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle(UserCreated $event)
    {
       $u = $event->user;
       $subject = 'Welcome to {{organization}}';//$u->organization->templates['welcome_email_subject']->template;
       $contents = $u->organization->templates['welcome_email']->template;
        
       $userinfo = '<br>Username: '.$u->email.
                   '<br>Password: '.substr(md5($u->first.$u->last),3,6).'<br>';
        
       $subject = preg_replace('/{{\s*organization\s*}}/',$u->organization->name,$subject);
       $contents = preg_replace('/{{\s*name\s*}}/',$u->name,$contents);
       $contents = preg_replace('/{{\s*organization\s*}}/',$u->organization->name,$contents);
       $contents = preg_replace('/{{\s*content\s*}}/',$userinfo,$contents);
        
       mail('dhutchful@gmail.com', $subject, $contents, 'no-reply@gradlead.com');
    }

    public function failed(UserCreated $event, $exception)
    {
        Log::error('Sending mail failed: '.$exception);
    }
}
