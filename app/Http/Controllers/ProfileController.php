<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Gradlead\Profile;
use App\Gradlead\ProfileCompany;
use App\Gradlead\ProfileSchool;
use App\Gradlead\ProfileStudentEducation;
use App\Gradlead\ProfileStudentExperience;
use App\Gradlead\ProfileStudentLanguage;
use App\Gradlead\ProfileStudentPreference;
use App\Gradlead\ProfileStudentResume;
use App\Gradlead\ProfileStudentDoc;
use App\Gradlead\ProfileStudentSkill;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['avatar','pic','logo','crest','pdf','publicProfile']]);
        $this->middleware('tenant');
    }

    public function avatar(Request $request, $profileId)
    {
        $b = Profile::findOrFail($profileId);
        return $this->display_image_new($b->file_path);
    }

    public function pic(Request $request, $profileId)
    {
        $b = ProfileCompany::findOrFail($profileId);
        return $this->display_image_new($b->pic_path);
    }

    public function logo(Request $request, $profileId)
    {
        $b = ProfileCompany::findOrFail($profileId);
        return $this->display_image_new($b->file_path);
    }

    public function crest(Request $request, $profileId)
    {
        $b = ProfileSchool::findOrFail($profileId);
        return $this->display_image_new($b->file_path);
    }

    public function pdf(Request $request, $profileId)
    {
        $b = ProfileStudentResume::findOrFail($profileId);
        return $this->display_image_new($b->file_path);
    }
    
    public function doc(Request $request, $profileId)
    {
        $b = ProfileStudentDoc::findOrFail($profileId);
        return $this->display_image_new($b->file_path);
    }


    // GET
    public function userProfiles()
    {
        $items = Profile::all();
        return $this->json_response($items);
    }
    public function employerProfiles()
    {
        $items = ProfileCompany::all();
        return $this->json_response($items);
    }
    public function schoolProfiles()
    {
        $items = ProfileSchool::all();
        return $this->json_response($items);
    }

    
    // STORE
    public function storeEmployerProfile(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'organization_id' => 'required|exists:organizations,id',
            'summary' => 'required',
        ]);

        $i = new ProfileCompany();
        $i->organization_id = $request->organization_id;
        $i->summary = $request->summary;
        $i->description = $request->description;
        $i->num_employees = isset($request->num_employees) ? $request->num_employees:null;
        $i->country = $request->country;
        $i->city = $request->city;
        $i->neighborhood = $request->neighborhood;
        $i->street = $request->street;
        $i->job_types = $request->jobtypes;
        $i->industries = $request->industries;
        $i->website = isset($request->website) ? $request->website:null;

        if ($request->logo <> '') {
            $fInfo = $this->handleFileUpload($request, 'logo', 'files/logos/');
            $i->file_name = $fInfo['name'];
            $i->file_path = $fInfo['path'];
            $i->file_url = $fInfo['url'];
        }

        if ($request->pic <> '') {
            $fInfo = $this->handleFileUpload($request, 'pic', 'files/images/');
            $i->pic_name = $fInfo['name'];
            $i->pic_path = $fInfo['path'];
            $i->pic_url = $fInfo['url'];
        }


        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function storeSchoolProfile(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'organization_id' => 'required|exists:organizations,id',
            'summary' => 'required',
            'file_name' => 'string',
            'icon_file' => 'string'
        ]);

		$i = new ProfileSchool();

 		if ($request->icon_file<>'') {
            $fInfo = $this->handleNewFileUpload($request, 'files/logos/');
            if (is_array($fInfo)) {
                $i->file_name = $fInfo['name'];
                $i->file_path = $fInfo['path'];
                $i->file_url = $fInfo['url'];
            } else {
                return $this->json_response (
                    ['icon_file' => ['The file size cannot exceed 20MB.']],true, 422
                );
            }
        }

       	$i->organization_id = $request->organization_id;
       	$i->summary = $request->summary;
        $i->country = $request->country;
        $i->city = $request->city;
        $i->neighborhood = $request->neighborhood;
        $i->street = $request->street;
       	$i->modified_by = $user->id;
       	$i->save();

        return $this->json_response($i);
    }

    public function storeUserProfile(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'summary' => 'required',
            'file_name' => 'string',
            'icon_file' => 'string'
        ]);

        $i = new Profile();
        $i->user_id = $request->user_id;
        $i->phone = $request->phone;
        $i->summary = $request->summary;
        $i->country = $request->country;
        $i->city = $request->city;
        $i->neighborhood = $request->neighborhood;
        $i->street = $request->street;
        
        if ($request->icon_file<>'') {
            $fInfo = $this->handleNewFileUpload($request, 'files/avatars/');
            if (is_array($fInfo)) {
                $i->file_name = $fInfo['name'];
                $i->file_path = $fInfo['path'];
                $i->file_url = $fInfo['url'];
            } else {
                return $this->json_response (
                    ['icon_file' => ['The file size cannot exceed 20MB.']],true, 422
                );
            }
        }

        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function storeUserEducation(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'university' => 'required|max:255',
            'country' => 'required|max:255',
            'degree_level' => 'required|max:255',
            'degree_major' => 'required|max:255',
            'graduation_month' => 'required|numeric',
            'graduation_year' => 'required|numeric',
            'gpa' => 'required|numeric',
            'visible' => 'required|in:0,1'
        ]);

        $i = new ProfileStudentEducation();
        $i->user_id = $request->user_id;
        $i->university = $request->university;
        $i->country = $request->country;
        $i->degree_level = $request->degree_level;
        $i->degree_major = $request->degree_major;
        $i->graduation_year = $request->graduation_year;
        $i->graduation_month = $request->graduation_month;
        $i->gpa = $request->gpa;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
    
    public function storeUserPrimary(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'school' => 'required|max:255',
            'country' => 'required|max:255',
            'graduation_month' => 'required|numeric',
            'graduation_year' => 'required|numeric',
            'visible' => 'required|in:0,1'
        ]);

        $i = new ProfileStudentEducationPrimary();
        $i->user_id = $request->user_id;
        $i->school = $request->school;
        $i->country = $request->country;
        $i->graduation_year = $request->graduation_year;
        $i->graduation_month = $request->graduation_month;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
    
    public function storeUserClub(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'position' => 'required|max:255',
            'visible' => 'required|in:0,1'
        ]);

        $i = new ProfileStudentClub();
        $i->user_id = $request->user_id;
        $i->name = $request->name;
        $i->position = $request->position;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function storeUserExperience(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'company' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required',
            'country' => 'required|max:255',
            'city' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'visible' => 'required|in:0,1'
        ]);

        $i = new ProfileStudentExperience();
        $i->user_id = $request->user_id;
        $i->company = $request->company;
        $i->title = $request->title;
        $i->description = $request->description;
        $i->country = $request->country;
        $i->city = $request->city;
        $i->neighborhood = $request->neighborhood;
        $i->start_date = $request->start_date;
        $i->end_date = $request->end_date;
        $i->current = ($request->current<>'') ? 1 : 0;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function storeUserLanguage(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'language' => 'required|max:255',
            'level' => 'required',
            'visible' => 'required|in:0,1'
        ]);

        $i = new ProfileStudentLanguage();
        $i->user_id = $request->user_id;
        $i->language = $request->language;
        $i->level = $request->level;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function storeUserPreference(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id'
        ]);

        $i = new ProfileStudentPreference();
        $i->user_id = $request->user_id;
        $i->job_types = $request->job_types;
        $i->job_positions = $request->positions;
        $i->countries = $request->countries;
        $i->remote_work = ($request->remote_work=='') ? 0:1;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function storeUserResume(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'file_name' => 'string',
            'icon_file' => 'string'
        ]);

        if (ProfileStudentResume::withinLimits($request->user_id)) {
            $i = new ProfileStudentResume();
            $i->user_id = $request->user_id;
            $i->description = $request->description;
            $i->name = $request->name;
            $i->default = 0;

            if ($request->pdf_file<>'') {
                $fInfo = $this->handleNewFileUpload($request, 'files/resumes/');
                if (is_array($fInfo)) {
                    $i->file_name = $fInfo['name'];
                    $i->file_path = $fInfo['path'];
                    $i->file_url = $fInfo['url'];
                } else {
                    return $this->json_response (
                        ['pdf_file' => ['The file size cannot exceed 20MB.']],true, 422
                    );
                }
            }

            $i->modified_by = $user->id;
            $i->save();

            ProfileStudentResume::setDefault($i, $request->default);
        }

        return $this->json_response($i);
    }

    public function storeUserDoc(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'file_name' => 'string',
            'icon_file' => 'string'
        ]);

        $i = new ProfileStudentDoc();
        $i->user_id = $request->user_id;
        $i->description = $request->description;
        $i->name = $request->name;

        if ($request->pdf_file<>'') {
            $fInfo = $this->handleNewFileUpload($request, 'files/docs/');
            if (is_array($fInfo)) {
                $i->file_name = $fInfo['name'];
                $i->file_path = $fInfo['path'];
                $i->file_url = $fInfo['url'];
            } else {
                return $this->json_response (
                    ['pdf_file' => ['The file size cannot exceed 20MB.']],true, 422
                );
            }
        }

        $i->modified_by = $user->id;
        $i->save();


        return $this->json_response($i);
    }
    

    public function storeUserSkill(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'skills' => 'required',
            'visible' => 'required|in:0,1'
        ]);

        $i = new ProfileStudentSkill();
        $i->user_id = $request->user_id;
        $i->skills = $request->skills;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }





    // UPDATE
    public function updateEmployerProfile(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id' => 'required|exists:profiles_companies,id',
            'organization_id' => 'required|exists:organizations,id',
            'summary' => 'required',
            'description' => 'required',
            'country' => 'required|max:255',
            'city' => 'required',
            'street' => 'required',
            'jobtypes' => 'required',
            'industries' => 'required',
            'num_employees'=>'numeric',
            'website'=> 'url',
            'file_name' => 'string',
            'icon_file' => 'string'
        ]);

        $i = ProfileCompany::find($request->id);
        $i->organization_id = $request->organization_id;
        $i->summary = $request->summary;
        $i->description = $request->description;
        $i->num_employees = isset($request->num_employees) ? $request->num_employees:null;
        $i->country = $request->country;
        $i->city = $request->city;
        $i->neighborhood = $request->neighborhood;
        $i->street = $request->street;
        $i->job_types = $request->jobtypes;
        $i->industries = $request->industries;
        $i->website = isset($request->website) ? $request->website:null;

        if ($request->icon_file<>'') {
            Storage::delete($i->file_path);
            $fInfo = $this->handleNewFileUpload($request, 'files/logos/');
            if (is_array($fInfo)) {
                $i->file_name = $fInfo['name'];
                $i->file_path = $fInfo['path'];
                $i->file_url = $fInfo['url'];
            } else {
                return $this->json_response (
                    ['icon_file' => ['The file size cannot exceed 20MB.']],true, 422
                );
            }
        }

        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function updateSchoolProfile(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id' => 'required|exists:profiles_schools,id',
            'organization_id' => 'required|exists:organizations,id',
            'summary' => 'required',
            'file_name' => 'string',
            'icon_file' => 'string'
        ]);

        $i = ProfileSchool::find($request->id);
        $i->organization_id = $request->organization_id;
        $i->summary = $request->summary;
        $i->country = $request->country;
        $i->city = $request->city;
        $i->neighborhood = $request->neighborhood;
        $i->street = $request->street;

 		if ($request->icon_file<>'') {
            Storage::delete($i->file_path);
           $fInfo = $this->handleNewFileUpload($request, 'files/logos/');
            if (is_array($fInfo)) {
                $i->file_name = $fInfo['name'];
                $i->file_path = $fInfo['path'];
                $i->file_url = $fInfo['url'];
            } else {
                return $this->json_response (
                    ['icon_file' => ['The file size cannot exceed 20MB.']],true, 422
                );
            }
        }

        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function updateUserProfile(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'summary' => 'required|max:255',
            'file_name' => 'string',
            'icon_file' => 'string'
        ]);

        $u = User::find($request->user_id);
        $i = Profile::find($u->profile->id);
        $i->user_id = $request->user_id;
        $i->phone = $request->phone;
        $i->summary = $request->summary;
        $i->country = $request->country;
        $i->city = $request->city;
        $i->neighborhood = $request->neighborhood;
        $i->street = $request->street;

 		if ($request->icon_file<>'') {
            Storage::delete($i->file_path);
           $fInfo = $this->handleNewFileUpload($request, 'files/avatars/');
            if (is_array($fInfo)) {
                $i->file_name = $fInfo['name'];
                $i->file_path = $fInfo['path'];
                $i->file_url = $fInfo['url'];
            } else {
                return $this->json_response (
                    ['icon_file' => ['The file size cannot exceed 20MB.']],true, 422
                );
            }
        }

        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function updateUserEducation(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id'=>'required|exists:profiles_student_education,id',
            'user_id' => 'required|exists:users,id',
            'university' => 'required|max:255',
            'country' => 'required|max:255',
            'degree_level' => 'required|max:255',
            'degree_major' => 'required|max:255',
            'graduation_month' => 'required|numeric',
            'graduation_year' => 'required|numeric',
            'gpa' => 'required|numeric',
            'visible' => 'required|in:0,1',
        ]);

        $i = ProfileStudentEducation::find($request->id);
        $i->user_id = $request->user_id;
        $i->university = $request->university;
        $i->country = $request->country;
        $i->degree_level = $request->degree_level;
        $i->degree_major = $request->degree_major;
        $i->graduation_year = $request->graduation_year;
        $i->graduation_month = $request->graduation_month;
        $i->gpa = $request->gpa;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function updateUserPrimary(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id'=>'required|exists:profiles_student_education_primary,id',
            'user_id' => 'required|exists:users,id',
            'school' => 'required|max:255',
            'country' => 'required|max:255',
            'graduation_month' => 'required|numeric',
            'graduation_year' => 'required|numeric',
            'visible' => 'required|in:0,1',
        ]);

        $i = ProfileStudentEducationPrimary::find($request->id);
        $i->user_id = $request->user_id;
        $i->school = $request->school;
        $i->country = $request->country;
        $i->graduation_year = $request->graduation_year;
        $i->graduation_month = $request->graduation_month;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
    
    public function updateUserClub(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id'=>'required|exists:profiles_student_clubs,id',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'position' => 'required|max:255',
            'visible' => 'required|in:0,1',
        ]);

        $i = ProfileStudentClub::find($request->id);
        $i->user_id = $request->user_id;
        $i->name = $request->name;
        $i->position = $request->position;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

   
    public function updateUserExperience(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id'=>'required|exists:profiles_student_work,id',
            'user_id' => 'required|exists:users,id',
            'company' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required',
            'country' => 'required|max:255',
            'city' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|after_or_equal:start_date',
            'visible' => 'required|in:0,1',
        ]);

        $i = ProfileStudentExperience::find($request->id);
        $i->user_id = $request->user_id;
        $i->company = $request->company;
        $i->title = $request->title;
        $i->description = $request->description;
        $i->city = $request->city;
        $i->start_date = $request->start_date;
        $i->end_date = $request->end_date;
        $i->country = $request->country;
        $i->neighborhood = $request->neighborhood;
        $i->current = ($request->current<>'') ? 1:0;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function updateUserLanguage(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id' => 'required|exists:profiles_student_languages,id',
            'user_id' => 'required|exists:users,id',
            'language' => 'required|max:255',
            'level' => 'required',
            'visible' => 'required|in:0,1'
        ]);

        $i = ProfileStudentLanguage::find($request->id);
        $i->user_id = $request->user_id;
        $i->language = $request->language;
        $i->level = $request->level;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function updateUserPreference(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id' => 'required|exists:profiles_student_preferences,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $i = ProfileStudentPreference::find($request->id);
        $i->user_id = $request->user_id;
        $i->job_types = $request->job_types;
        $i->job_positions = $request->positions;
        $i->countries = $request->countries;
        $i->remote_work = ($request->remote_work=='') ? 0 : 1;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function updateUserResume(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id'=>'required|exists:profiles_student_resumes,id',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'file_name' => 'string',
            'icon_file' => 'string'
        ]);

        $i = ProfileStudentResume::find($request->id);
        $i->user_id = $request->user_id;
        $i->name = $request->name;
        $i->default = 0;

        if ($request->pdf_file<>'') {
            $fInfo = $this->handleNewFileUpload($request, 'files/resumes/');
            if (is_array($fInfo)) {
                $i->file_name = $fInfo['name'];
                $i->file_path = $fInfo['path'];
                $i->file_url = $fInfo['url'];
            } else {
                return $this->json_response (
                    ['pdf_file' => ['The file size cannot exceed 20MB.']],true, 422
                );
            }
        }

        $i->modified_by = $user->id;
        $i->save();

        ProfileStudentResume::setDefault($i, $request->default);

        return $this->json_response($i);
    }

    public function updateUserResumeDefault(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id'=>'required|exists:profiles_student_resumes,id',
            'default' => 'required',
        ]);

        $i = ProfileStudentResume::find($request->id);
        $i->default = 0;
        $i->modified_by = $user->id;
        $i->save();

        ProfileStudentResume::setDefault($i, $request->default);

        return $this->json_response($i);
    }
     
    public function updateUserDoc(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id'=>'required|exists:profiles_student_resumes,id',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'file_name' => 'string',
            'icon_file' => 'string'
        ]);

        $i = ProfileStudentDoc::find($request->id);
        $i->user_id = $request->user_id;
        $i->name = $request->name;

        if ($request->pdf_file<>'') {
            $fInfo = $this->handleNewFileUpload($request, 'files/docs/');
            if (is_array($fInfo)) {
                $i->file_name = $fInfo['name'];
                $i->file_path = $fInfo['path'];
                $i->file_url = $fInfo['url'];
            } else {
                return $this->json_response (
                    ['pdf_file' => ['The file size cannot exceed 20MB.']],true, 422
                );
            }
        }

        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function updateUserSkill(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'id' => 'required|exists:profiles_student_skills,id',
            'user_id' => 'required|exists:users,id',
            'skills' => 'required',
            'visible' => 'required|in:0,1'
        ]);

        $i = ProfileStudentSkill::find($request->id);
        $i->user_id = $request->user_id;
        $i->skills = $request->skills;
        $i->visible = $request->visible;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }




    // DESTROY
    public function destroyUserEducation(Request $request, $itemId)
    {
        return $this->processDestroy(ProfileStudentEducation::find($itemId));
    }
    
    public function destroyUserPrimary(Request $request, $itemId)
    {
        return $this->processDestroy(ProfileStudentEducationPrimary::find($itemId));
    }

    public function destroyUserClub(Request $request, $itemId)
    {
        return $this->processDestroy(ProfileStudentClub::find($itemId));
    }

    public function destroyUserExperience(Request $request, $itemId)
    {
        return $this->processDestroy(ProfileStudentExperience::find($itemId));
    }

    public function destroyUserLanguage(Request $request, $itemId)
    {
        return $this->processDestroy(ProfileStudentLanguage::find($itemId));
    }

    public function destroyUserPreference(Request $request, $itemId)
    {
        return $this->processDestroy(ProfileStudentPreference::find($itemId));
    }

    public function destroyUserResume(Request $request, $itemId)
    {
        return $this->processDestroy(ProfileStudentResume::find($itemId));
    }
    
    public function destroyUserDoc(Request $request, $itemId)
    {
        return $this->processDestroy(ProfileStudentDoc::find($itemId));
    }

    public function destroyUserSkill(Request $request, $itemId)
    {
        return $this->processDestroy(ProfileStudentSkill::find($itemId));
    }
}
