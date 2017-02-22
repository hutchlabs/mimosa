<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function ($router) {
        Auth::routes();

        $router->get('/start', function() {
            return response()->json('ok',200);
        });

    
        $router->get('/',           'WelcomeController@index');
        $router->get('/schools',    'WelcomeController@schools');
        $router->get('/contact',    'WelcomeController@contact');
        $router->get('/login',      'WelcomeController@index');
        $router->get('/home',       'HomeController@index');
        $router->get('/fauthuser',  'ApiController@authuser');
        $router->get('/flogout',    'ApiController@logout');
        $router->post('/flogin',    'ApiController@authenticate');
        $router->post('/fregister', 'ApiController@registeruser');

        // Search
        $router->post('search/jobs',        'SearchController@findJobs');
        $router->post('search/users',       'SearchController@findCandidates');
        $router->post('search/employers',   'SearchController@findEmployers');
  
        // Jobs & Applications
        $router->get('jobs',                                'JobController@index');
        $router->get('jobs/featured',                       'JobController@featured');
        $router->get('jobs/applications',                   'JobController@applications');
        $router->get('jobs/applications/{id}/status/{s}',   'JobController@updateAppStatus');
        $router->post('jobs',                               'JobController@store');
        $router->post('jobs/apply',                         'JobController@apply');
        $router->put('jobs/{id}',                           'JobController@update');
        $router->put('jobs/{id}/changestatus',              'JobController@updateStatus');
        $router->put('jobs/{id}/changefeature',              'JobController@updateFeature');
        $router->put('jobs/application/update',             'JobController@updateApplication');
        $router->delete('jobs/{id}',                        'JobController@destroy');
        $router->delete('jobs/application/{id}',            'JobController@unapply');
      
        // Users
        $router->get('users',                              'UserController@index');
        $router->post('users',                             'UserController@store');
        $router->post('users/alert',                       'UserController@alert');
        $router->post('users/badge',                       'UserController@merit');
        $router->post('users/bookmark',                    'UserController@bookmark');
        $router->post('users/address',                     'UserController@storeAddress');
        $router->put('users/{id}',                         'UserController@update');
        $router->put('users/alert/{aid}',                  'UserController@updateAlert');
        $router->put('users/address/{aid}',                'UserController@updateAddress');
        $router->delete('users/{id}',                      'UserController@destroy');
        $router->delete('users/alert/{aid}',               'UserController@unalert');
        $router->delete('users/badge/{aid}',               'UserController@demerit');
        $router->delete('users/bookmark/{bid}',            'UserController@unbookmark');
        $router->delete('users/address/{aid}',             'UserController@destroyAddress');

        // Organizations
        $router->get('organizations',                       'OrganizationController@index');
        $router->get('organizations/featured',              'OrganizationController@featured');
        $router->post('organizations',                      'OrganizationController@store');
        $router->post('organizations/addaffiliate',         'OrganizationController@storeAffiliate');
        $router->put('organizations/updateapproval/{id}',   'OrganizationController@updateAffiliateApproval');
        $router->put('organizations/{id}',                  'OrganizationController@update');
        $router->delete('organizations/{id}',               'OrganizationController@destroy');
    
        
        // Profiles
        $router->get('profiles/users',                      'ProfileController@userProfiles');
        $router->get('profiles/employees',                  'ProfileController@employeeProfiles');
        $router->get('profiles/schools',                    'ProfileController@schoolProfiles');
        $router->get('profiles/logo/{id}',                  'ProfileController@logo');
        $router->get('profiles/crest/{id}',                 'ProfileController@crest');
        $router->get('profiles/avatar/{id}',                'ProfileController@avatar');
        $router->get('profiles/pic/{id}',                   'ProfileController@pic');
        $router->post('profiles/users',                     'ProfileController@storeUserProfile');
        $router->post('profiles/users/education',           'ProfileController@storeUserEducation');   
        $router->post('profiles/users/experience',          'ProfileController@storeUserExperience');   
        $router->post('profiles/users/language',            'ProfileController@storeUserLanguage');   
        $router->post('profiles/users/preference',          'ProfileController@storeUserPreference');
        $router->post('profiles/users/resume',              'ProfileController@storeUserResume');   
        $router->post('profiles/users/skill',               'ProfileController@storeUserSkill');
        $router->post('profiles/employees',                 'ProfileController@storeEmployeeProfile');
        $router->post('profiles/schools',                   'ProfileController@storeSchoolProfile');
        $router->put('profiles/users/{id}',                 'ProfileController@updateUserProfile');
        $router->put('profiles/users/education/{id}',       'ProfileController@updateUserEducation');   
        $router->put('profiles/users/experience/{id}',      'ProfileController@updateUserExperience');   
        $router->put('profiles/users/language/{id}',        'ProfileController@updateUserLanguage');   
        $router->put('profiles/users/preference/{id}',      'ProfileController@updateUserPreference');
        $router->put('profiles/users/resume/{id}',          'ProfileController@updateUserResume');   
        $router->put('profiles/users/skill/{id}',           'ProfileController@updateUserSkill');
        $router->put('profiles/employees/{id}',             'ProfileController@updateEmployeeProfile');
        $router->put('profiles/schools/{id}',               'ProfileController@updateSchoolProfile');
        $router->delete('profiles/users/education/{id}',    'ProfileController@destroyUserEducation');   
        $router->delete('profiles/users/experience/{id}',   'ProfileController@destroyUserExperience');   
        $router->delete('profiles/users/language/{id}',     'ProfileController@destroyUserLanguage');   
        $router->delete('profiles/users/preference/{id}',   'ProfileController@destroyUserPreference');
        $router->delete('profiles/users/resume/{id}',       'ProfileController@destroyUserResume');   
        $router->delete('profiles/users/skill/{id}',        'ProfileController@destroyUserSkill');   

        // Plans & Contracts
        $router->get('plans',                   'PlanController@index');
        $router->get('contracts',               'PlanController@contracts');
        $router->post('plans',                  'PlanController@store');
        $router->put('plans/{id}',              'PlanController@update');
        $router->delete('plans/{id}',           'PlanController@destroy');
    
        // Questionnaires
        $router->get('questionnaires',          'QuestionnaireController@index');
        $router->post('questionnaires',         'QuestionnaireController@store');
        $router->put('questionnaires/{id}',     'QuestionnaireController@update');
        $router->delete('questionnaires/{id}',  'QuestionnaireController@destroy');
    
        // Questions
        $router->get('questionnaires/questions',            'QuestionnaireController@showQuestions');
        $router->post('questionnaires/questions',           'QuestionnaireController@storeQuestion');
        $router->put('questionnaires/questions/{id}',       'QuestionnaireController@updateQuestion');
        $router->delete('questionnaires/questions/{id}',    'QuestionnaireController@destroyQuestion');
    
        // Badges
        $router->get('badges',                  'BadgeController@index');
        $router->get('badges/image/{id}',       'BadgeController@badgeImage');
        $router->post('badges',                 'BadgeController@store');
        $router->put('badges',                  'BadgeController@update');
        $router->delete('badges/{id}',          'BadgeController@destroy');

        // Events
        $router->get('events',                  'EventController@index');
        $router->post('events',                 'EventController@store');
        $router->put('events/{id}',             'EventController@update');
        $router->delete('events/{id}',          'EventController@destroy');
    
        // Themes
        $router->get('themes',                  'ThemeController@index');
        $router->get('themes/default',          'ThemeController@defaultTheme');
        $router->post('themes/editable',        'ThemeController@editable');
        $router->post('themes',                 'ThemeController@store');
        $router->put('themes/{id}',              'ThemeController@update');
    
        // System Methods
        $router->get('degrees',                 'SystemController@degrees');
        $router->post('degrees',                'SystemController@storeDegree');
        $router->put('degrees/{id}',            'SystemController@updateDegree');
        $router->delete('degrees/{id}',         'SystemController@destroyDegree');
    
        $router->get('industries',              'SystemController@industries');
        $router->post('industries',             'SystemController@storeIndustry');
        $router->put('industries/{id}',         'SystemController@updateIndustry');
        $router->delete('industries/{id}',      'SystemController@destroyIndustry');
        
        $router->get('jobtypes',                'SystemController@jobTypes');
        $router->post('jobtypes',               'SystemController@storeJobType');
        $router->put('jobtypes/{id}',           'SystemController@updateJobType');
        $router->delete('jobtypes/{id}',        'SystemController@destroyJobType');
        
        $router->get('languages',               'SystemController@languages');
        $router->post('languages',              'SystemController@storeLanguage');
        $router->put('languages/{id}',          'SystemController@updateLanguage');
        $router->delete('languages/{id}',       'SystemController@destroyLanguage');
    
        $router->get('majors',                  'SystemController@majors');
        $router->post('majors',                 'SystemController@storeMajor');
        $router->put('majors/{id}',             'SystemController@updateMajor');
        $router->delete('majors/{id}',          'SystemController@destroyMajor');
    
        $router->get('permissions',             'SystemController@permissions');
        $router->post('permissions',            'SystemController@storePermission');
        $router->put('permissions/{id}',        'SystemController@updatePermission');
    
        $router->get('skills',                  'SystemController@skills');
        $router->post('skills',                 'SystemController@storeSkill');
        $router->put('skills/{id}',             'SystemController@updateSkill');
        $router->delete('skills/{id}',          'SystemController@destroySkill');
    
        $router->get('universities',            'SystemController@universities');
        $router->post('universities',           'SystemController@storeUniversity');
        $router->put('universities/{id}',       'SystemController@updateUniversity');
        $router->delete('universities/{id}',    'SystemController@destroyUniversity');
    
        $router->get('roles',  function() { return \App\Gradlead\Role::all(); });
});


