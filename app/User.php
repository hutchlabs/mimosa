<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Support\Facades\DB;

use App\Gradlead\Profile;
use App\Profile\Organization;

class User extends Authenticatable
{
    use Notifiable, BelongsToTenants;

    protected $fillable = ['first', 'last', 'email', 'password',];

    protected $hidden = ['password', 'remember_token',];

    protected $with = ['achievements','alerts','applications','bookmarks','inbox','outbox','organization','role'];
    
    protected function getArrayableAppends()
    {
        $appends = ['name','profile','profile_url'];
        
        if ($this->isStudent()) {
            $appends = array_merge($appends, ['clubs','docs','education','languages','primary','preferences','resumes','skills','work']);
        } else {
            $appends = array_merge($appends,['contacts','templates']);
        }
        
        
        $this->appends = array_merge($this->appends, $appends);
        return parent::getArrayableAppends();
    }
    
    protected function getNameAttribute()
    {
        return trim($this->first.' '.$this->last);
    }
    
    protected function getProfileUrlAttribute()
    {
       return '/u/'.$this->uuid;
    }
    
    protected function getEducationAttribute()
    {
        $ed= DB::table('profiles_student_education')->select(DB::raw('*'))->where('user_id',$this->id)->get(); 
        
        if (!is_null($ed) && sizeof($ed)) {
            foreach($ed as $key => $val) {     
                $monthName = date('F', mktime(0, 0, 0, $val->graduation_month, 10));
                $ed[$key]->graduation = $monthName.', '.$val->graduation_year;  
            }
        }
        return $ed;
    }

    protected function getPrimaryAttribute()
    {
        $ed= DB::table('profiles_student_education_primary')->select(DB::raw('*'))->where('user_id',$this->id)->get(); 
        
        if (!is_null($ed) && sizeof($ed)) {
            foreach($ed as $key => $val) {     
                $monthName = date('F', mktime(0, 0, 0, $val->graduation_month, 10));
                $ed[$key]->graduation = $monthName.', '.$val->graduation_year;  
            }
        }
        return $ed;
    }
    
    protected function getContactsAttribute()
    {
        $contacts = [];
        $x = DB::table('mailing_list')->select(DB::raw('*'))->where('organization_id',$this->organization_id)->get();
        foreach($x as $c) { 
                            array_push($contacts, 
                                       ['text'=>$c->name,'value'=>$c->contacts,
                                        'id'=>$c->id,
                                        'name'=>$c->name,
                                        'description'=>$c->description,
                                        'contacts'=>$c->contacts,
                                        'type'=>'list'
                                       ]); 
                          }
        
        if ($this->isGradlead()) {
            $x = DB::table('users')
                ->join('organizations', 'users.organization_id','=', 'organizations.id')
                ->select('users.*','organizations.name as o')
                ->orderBy('o')->orderBy('users.first')
                ->get();
            foreach($x as $u) { 
                if ($u->id !=$this->id) {  
                    array_push($contacts, ['type'=>'normal','text'=>$u->o.' > '.trim($u->first.' '.$u->last),'value'=>$u->id]); 
                }
            }
        } else {
            $x = DB::table('users')
                ->select(DB::raw("users.id, CONCAT(users.first,' ',users.last) as name"))
                ->where('organization_id',$this->organization_id)
                ->orderBy('users.first')
                ->get();
            foreach($x as $u) { 
                if ($u->id !=$this->id) {
                    array_push($contacts, ['type'=>'normal','text'=>trim($u->name),'value'=>$u->id]); 
                }
            }
        }
        return $contacts;
    }
    
    protected function getTemplatesAttribute()
    {
        $templates = [];
        $x = DB::table('mailing_templates')->select(DB::raw('*'))->where('organization_id',$this->organization_id)->get();
        foreach($x as $t) { 
            array_push($templates, ['text'=>$t->name,
                                    'id'=>$t->id,
                                    'name'=>$t->name,
                                    'description'=>$t->description,
                                    'template'=>$t->template,
                                    'value'=>$t->template]); 
        }
        return $templates;
    }
    
    protected function getClubsAttribute()
    {
        $ed= DB::table('profiles_student_clubs')->select(DB::raw('*'))->where('user_id',$this->id)->get(); 
        return $ed;
    }
    
    protected function getLanguagesAttribute()
    {
        return DB::table('profiles_student_languages')->select(DB::raw('*'))->where('user_id',$this->id)->get(); 
    }
    
    protected function getPreferencesAttribute()
    {
        return DB::table('profiles_student_preferences')->select(DB::raw('*'))->where('user_id',$this->id)->first(); 
    }
    
    protected function getResumesAttribute()
    {
        return DB::table('profiles_student_resumes')->select(DB::raw('*'))->where('user_id',$this->id)->get(); 
    }
    
    protected function getDocsAttribute()
    {
        return DB::table('profiles_student_docs')->select(DB::raw('*'))->where('user_id',$this->id)->get(); 
    }
    
    protected function getSkillsAttribute()
    {
        return DB::table('profiles_student_skills')->select(DB::raw('*'))->where('user_id',$this->id)->get(); 
    }
    
    protected function getWorkAttribute()
    {
        return DB::table('profiles_student_work')->select(DB::raw('*'))->where('user_id',$this->id)->get(); 
    }
        
    public function getProfileAttribute()
    {
        $profile = DB::table('profiles_users')->select(DB::raw('*'))->where('user_id',$this->id)->first(); 
        if (is_null($profile)) {   
            $profile = new Profile();
            $profile->user_id = $this->id;
            $profile->summary = "This is the default profile text. Please update your profile.";
            $profile->modified_by = 1;
            $profile->save();
        } else {
            $profile->avatar = 'img/a0.jpg';
            if ($profile->file_name<>'') {
                $profile->avatar = '/profiles/avatar/'.$profile->id.'?'.date('Y-m-d');
            }
        }
        
        $address = [];
        if ($profile->street<>'') { array_push($address, $profile->street); }
        if ($profile->neighborhood<>'') { array_push($address, $profile->neighborhood); }
        if ($profile->city<>'') { array_push($address, $profile->city); }
        if ($profile->country<>'') { array_push($address, $profile->country); }
        $profile->address = (sizeof($address)>0) ? join('<br/> ',$address) : 'No address given';
        return $profile;
    }
    
    public function role()
    {
        return $this->hasOne('\App\Gradlead\Role', 'id', 'role_id');
    }

    public function organization()
    {
        return $this->belongsTo('\App\Gradlead\Organization');
    }

    public function alerts()
    {
        return $this->hasMany('\App\Gradlead\Alert', 'user_id', 'id');
    }
  
    public function applications()
    {
        return $this->hasMany('\App\Gradlead\Application', 'user_id', 'id');
    }

    public function achievements()
    {
        return $this->hasMany('\App\Gradlead\Achievement', 'user_id', 'id');
    }

    public function bookmarks()
    {
        return $this->hasMany('\App\Gradlead\Bookmark', 'user_id', 'id');
    }
    
    public function inbox()
    {
        return $this->hasMany('\App\Gradlead\Inbox');
    }
    
    public function outbox()
    {
        return $this->hasMany('\App\Gradlead\Inbox', 'from_id', 'id');
    }
        
    public static function scopeCandidates($query) 
    {
        return $query->whereRaw('user_type in ("student","graduate")')->get();
    }

    public function isSuperAdmin() 
    {
        return $this->role->name == 'Super Administrator'; 
    }
    
    public function isGradlead() 
    {
        return $this->type == 'gradlead'; 
    }
    
    public function isOrgUser() 
    {
        return ! $this->isStudent();
    }
    
    public function isStudent() 
    {
        return in_array($this->type, array('student','graduate')); 
    }
    
    public function cleanUp()
    {
        $this->address()->detach();
        $this->alerts()->detach();
        $this->achievements()->detach();
        $this->applications()->detach();
        $this->bookmarks()->detach();
        $this->profile()->detach();
    }
}
