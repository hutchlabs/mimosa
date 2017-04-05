<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Events\UserCreated;

use App\User;
use App\Gradlead\Achievement;
use App\Gradlead\Address;
use App\Gradlead\Alert;
use App\Gradlead\Badge;
use App\Gradlead\Bookmark;
use App\Gradlead\Profile;
use App\Gradlead\Inbox;
use App\Gradlead\MailTemplate;
use App\Gradlead\MailContact;
use ZipArchive;


class UserController extends Controller
{
    // TODO: Bulk uploads
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('tenant');
    }
    
    // Resume book
    public function getResumeBook(Request $request) 
    {
        $user = $request->user();
        
        $this->validate($request, ['users' => 'required']);
        
        $files = [];
        foreach($request->users as $u) {
            foreach($u['resumes'] as $r) {
                if (count($u['resumes'])==1 || $r['default']==1) {
                    if (Storage::exists($r['file_path'])) {
                        array_push($files, ['name'=>$u['last'].'_'.$u['first'].'_'.$u['uuid'].'.pdf',
                                        'file'=>$r['file_path']]);
                    }
                }
            }
        }
        //return $this->json_response($files);
        
        if (sizeof($files)) {
            $zipname = 'resumebook.zip';
            $zippath = 'files/'.$zipname;

            Storage::put($zippath, '');

            $zip = new ZipArchive;
            $tmp_file = tempnam('.','');
            if ($zip->open($tmp_file, ZipArchive::CREATE)!==TRUE) {
                return $this->error('Cannot open zip file at '.$zippath);
            } 
            
            $count=1;
            foreach($files as $f) {  
                //$zip->addFile(Storage::url($f['file']), $f['name']); 
                $zip->addFromString('test.txt'.$count, "no ");
            }
            $v = $zip->close();
            
            /*
            $x = 'nofiles';
            if ($zip->open($tmp_file)===TRUE) {
                $x='';
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $x .= "\nFilename: " . $zip->getNameIndex($i) . '<br />';
                }
                            $zip->close();
            }
            */
            
            //return $this->json_response(['files'=>$x,'save'=>$v]);
            $size = filesize($tmp_file);

            header("Content-Disposition: attachment; filename='resumebook.zip'");
            header('Content-Type: application/zip');
            header('Content-Length: ' . $size);
            //header("Pragma: no-cache"); 
            //header("Expires: 0");
            readfile($tmp_file);
            exit;
        } else {
            return $this->error('No resumes found.');
        }
    }
    
    
    // Messaging
    public function inbox(Request $request, $userId)
    {
        $items = [];
        $user = User::find($userId);
        if ($user) { $items = $user->inbox; }
        return $this->json_response($items);
    }
    
    public function outbox(Request $request, $userId)
    {
        $items = [];
        $user = User::find($userId);
        if ($user) { $items = $user->outbox; }
        return $this->json_response($items);
    }
    
    public function msgStore(Request $request) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['to' => 'required',
                         'subject' => 'required|max:255',
                         'message' => 'required']);
        
        $to = explode(',',$request->to);
        
        foreach($to as $t) {
            $i = new Inbox();
            $i->user_id = $t;
            $i->from_id = $user->id;
            $i->response_to = (isset($request->response_to)) ? $request->response_to:0;
            $i->subject = $request->subject;
            $i->message = $request->message;
            $i->seen = 0;
            $i->modified_by = $user->id;
            $i->save();   
        }
        return $this->ok();
    }
    
    public function msgRead(Request $request, $msgId) 
    {
        $user = $request->user();
        $i = Inbox::find($msgId);
        if ($i) { $i->markRead($user);}
        return $this->ok();
    }
    
    public function msgTrash(Request $request, $msgId) 
    {
        $user = $request->user();
        $i = Inbox::find($msgId);
        if ($i) { $i->markTrash($user);}
        return $this->ok();
    }
    
    public function msgDelete(Request $request, $msgId) 
    {
        $i = Inbox::find($msgId);
        if ($i) {
            $i->remove();
            return $this->ok();
        } else {
            return $this->json_response(['Cannot find message'], true);
        }
    }
    
    
    public function contacts(Request $request, $userId)
    {
        $items = [];
        $user = User::find($userId);
        if ($user) { $items = $user->inbox; }
        return $this->json_response($items);
    }
    
    public function msgAddContact(Request $request)
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['name' => 'required|max:255',
                         'description' => 'required',
                         'contacts' => 'required']);
        
        $i = new MailContact();
        $i->name = $request->name;
        $i->description = $request->description;
        $i->contacts = $request->contacts;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
    
    public function msgUpdateContact(Request $request, $contactId)
    {
        $user = $request->user();

        $this->validate($request, [
           'name' => 'required|max:255',
            'description' => 'required',
           'contacts' => 'required',
          ]
        );
        
        $i = MailContact::find($contactId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find contact to update'], true);    
        }
        
        $i->name = $request->name;
        $i->contacts = $request->contacts;
        $i->description = $request->description;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
    
    public function msgDeleteContact(Request $request, $contactId)
    {
        $i = MailContact::find($contactId);
        if ($i) { $i->delete(); }
        return $this->ok();
    }
    
    
    public function templates(Request $request, $userId)
    {
        $items = [];
        $user = User::find($userId);
        if ($user) { $items = $user->templates; }
        return $this->json_response($items);
    }
    
    public function msgAddTemplate(Request $request)
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['organization_id' => 'required|exists:organizations,id',
                         'name' => 'required|max:255',
                         'description' => 'required',
                         'template' => 'required'
                        ]);
        
        $i = new MailTemplate();
        $i->name = $request->name;
        $i->description = $request->description;
        $i->template = $request->template;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
    
    public function msgUpdateTemplate(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
           'name' => 'required|max:255',
           'description' => 'required',
           'template' => 'max:255',
          ]
        );
        
        $i = MailTemplate::find($itemId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find template to update'], true);    
        }
        
        $i->name = $request->name;
        $i->template = $request->template;
        $i->description = $request->description;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
    
    public function msgDeleteTemplate(Request $request, $itemId)
    {
        $i = MailTemplate::find($itemId);
        if ($i) { $i->delete(); }
        return $this->ok();
    }
    
    
    
    // Alerts
    public function alert(Request $request) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['user_id' => 'required|exists:users,id',
                         'name' => 'required:max:255',
                         'frequency' => 'required|in:daily,weekly,monthly']);
        
        $i = new Alert();
        $i->user_id = $request->user_id;
        $i->name = $request->name;
        $i->country = $request->country;
        $i->city = $request->city;
        $i->neighborhood = $request->neighborhood;
        $i->category = $request->category;
        $i->job_type = $request->jobtype;
        $i->language = $request->language;
        $i->frequency = $request->frequency;
        $i->next_run_date = Alert::setNextRun($request->frequency);
        $i->modified_by = $user->id;
        $i->save();
                
        return $this->ok();
    }
    
    public function updateAlert(Request $request, $alertId) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['id'=>'required|exists:users_alerts,id',
                         'user_id' => 'required|exists:users,id',
                         'name' => 'required:max:255',
                         'frequency' => 'required|in:daily,weekly,monthly']);
        
        $i = Alert::find($request->id);
        $i->user_id = $request->user_id;
        $i->name = $request->name;
        $i->country = $request->country;
        $i->city = $request->city;
        $i->neighborhood = $request->neighborhood;
        $i->category = $request->category;
        $i->job_type = $request->jobtype;
        $i->language = $request->language;
        $i->frequency = $request->frequency;
        $i->next_run_date = Alert::setNextRun($request->frequency);
        $i->modified_by = $user->id;
        $i->save();
                
        return $this->ok();
    }
    
    public function unalert(Request $request, $alertId) 
    {
        $i = Alert::find($alertId);
        if ($i) {
            $i->delete();
            return $this->ok();
        } else {
            return $this->json_response(['Cannot find alert'], true);
        }
    }
    
    // Badges
    public function merit(Request $request) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['user_id' => 'required|exists:users,id',
                         'badge_id' => 'required|exists:badges,id']);

        $a = new Achievement();
        $a->user_id = $request->user_id;
        $a->badge_id = $request->badge_id;
        $a->modified_by = $user->id;
        $a->save();
        
        return $this->ok();
    }
    
    public function demerit(Request $request, $achievementId) 
    {
        $a = Achievement::find($achievementId);
        if ($a) {
            $a->delete();
            return $this->ok();
        } else {
            return $this->json_response(['Cannot find achievement'], true);
        }
    }
    
    // Bookmarks
    public function bookmark(Request $request) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['user_id' => 'required|exists:users,id',
                         'description' => 'required|max:255',
                         'url' => 'required|max:255']);
        
        $i = new Bookmark();
        $i->user_id = $request->user_id;
        $i->description = $request->description;
        $i->url = $request->url;
        $i->modified_by = $user->id;
        $i->save();
              
        return $this->ok();
    }
    
    public function editBookmark(Request $request, $bookmarkId) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['user_id' => 'required|exists:users,id',
                         'description' => 'required|max:255',
                         'url' => 'required|max:255']);
        
        $i = Bookmark::find($bookmarkId);
        if ($i) {
            $i->user_id = $request->user_id;
            $i->description = $request->description;
            $i->url = $request->url;
            $i->modified_by = $user->id;
            $i->save();
        }        
        return $this->ok();
    }
    
    public function unbookmark(Request $request, $bookmarkId) 
    {
        $i = Bookmark::find($bookmarkId);
        if ($i) {
            $i->delete();
            return $this->ok();
        } else {
            return $this->json_response(['Cannot find bookmark'], true);
        }
    }
    
    
    //--------------------
    
    public function index(Request $request)
    {
        $users = [];
        
        $user = $request->user();
        
        if (!$user->isSuperAdmin()) {
            $users = User::all();   
        } else {
            $users = User::allTenants()->get();
        }
        
        return $this->json_response($users);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, ['email' => 'required|email|unique:users,email',
                                   'first' => 'required|max:255',
                                   'last' => 'required|max:255',
                                   'role_id' => 'required|exists:system_roles,id',
                                   'organization_id' => 'required|exists:organizations,id',
                                   'type' => 'required|in:employer,gradlead,graduate,school,student',
                                  ]
                                );

        // Add user
        $u = new User();
        $u->first = $request->first;
        $u->last = $request->last;  
        $u->email = $request->email;
        $u->password = Hash::make(substr(md5($request->last.$request->first),3,6));
        $u->uuid = md5($request->user_id.time());
        $u->organization_id = $request->organization_id;
        $u->role_id = $request->role_id;
        $u->type = $request->type;
        $u->modified_by = $user->id;
        $u->save();

        event(new UserCreated($u));

        $u = User::find($u->id);

        return $this->json_response($u);
    }

    public function update(Request $request, $userId)
    {
        $user = $request->user();
        $u = User::findOrFail($userId);

        $this->validate($request, [
                                   'email' => 'required|email|unique:users,email,'.$u->id,
                                   'first' => 'required|max:255',
                                   'last' => 'required|max:255',
                                   'uuid' => 'required|max:255|unique:users,uuid,'.$u->id,
                                   'role_id' => 'required|exists:system_roles,id',
                                   'organization_id' => 'required|exists:organizations,id',
                                   'type' => 'required|in:employer,gradlead,graduate,school,student',
                                  ]
                                );

        if ($request->password<>'') {
            if (sizeof($request->password)<6) {
                return $this->json_response(
                    ['password' => ['The password needs to be more than 6 characters.']], true, 422);
            } else {
                $u->password = Hash::make($request->password);
            }
        }

        // update user
        $u->first = $request->first;
        $u->last = $request->last;  
        $u->email = $request->email;
        $u->organization_id = $request->organization_id;
        $u->uuid = $request->uuid;
        $u->role_id = $request->role_id;
        $u->type = $request->type;
        $u->modified_by = $user->id;
        $u->save();
        
        return $this->json_response($u);
    }


    public function destroy(Request $request, $userId)
    {
        $i = User::find($userId);
        if (is_null($i)) {
            $this->json_report(['Cannot find user'], true);
        } else {
            $i->cleanUp();
            $i->delete();
            return $this->ok();
        }
    }
}