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
        $router->get('/vjobs',      'WelcomeController@jobs');
        $router->post('/vjobs',     'WelcomeController@jobs');
        $router->get('/employers',  'WelcomeController@employers');
        $router->post('/employers', 'WelcomeController@employers');

        $router->get('/partners',   'WelcomeController@partners');
        $router->get('/contact',    'WelcomeController@contact');
        $router->get('/login',      'WelcomeController@index');     
        $router->get('/u/{id}',     'WelcomeController@publicProfile');
        $router->get('/o/{id}',     'WelcomeController@publicOrg');
        $router->get('/j/{id}',     'WelcomeController@publicJob');

    
        $router->get('/home',       'HomeController@index');
        $router->get('/fauthuser',  'ApiController@authuser');
        $router->get('/flogout',    'ApiController@logout');
        $router->post('/flogin',    'ApiController@authenticate');
        $router->post('/fregister', 'ApiController@registeruser');

        // Search
        $router->get('search/jobs',        'SearchController@findJobs');
        $router->get('search/users',       'SearchController@findCandidates');
        $router->get('search/employers',   'SearchController@findEmployers');

        // Jobs & Applications
        $router->get('jobs',                                'JobController@index');
        $router->get('jobs/featured',                       'JobController@featured');
        $router->get('jobs/applications',                   'JobController@applications');
        $router->get('jobs/applications/{id}/status/{s}',   'JobController@updateAppStatus');
        $router->post('jobs',                               'JobController@store');
        $router->post('jobs/apply',                         'JobController@apply');
        $router->put('jobs/{id}',                           'JobController@update');
        $router->put('jobs/{id}/changestatus',              'JobController@updateStatus');
        $router->put('jobs/{id}/changefeature',             'JobController@updateFeature');
        $router->put('jobs/application/update',             'JobController@updateApplication');
        $router->delete('jobs/{id}',                        'JobController@destroy');
        $router->delete('jobs/application/{id}',            'JobController@unapply');

        // Users
        $router->get('users',                              'UserController@index');
        $router->get('users/inbox/{id}',                   'UserController@inbox');
        $router->get('users/outbox/{id}',                  'UserController@outbox');
        $router->get('users/message/contacts/{id}',        'UserController@contacts');
        $router->get('users/message/templates/{id}',       'UserController@templates');

        $router->post('users',                             'UserController@store');
        $router->post('users/alert',                       'UserController@alert');
        $router->post('users/badge',                       'UserController@merit');
        $router->post('users/bookmark',                    'UserController@bookmark');
        $router->post('users/inbox',                       'UserController@msgStore');
        $router->post('users/resumebook',                  'UserController@getResumeBook');
        $router->post('users/message/contacts',            'UserController@msgAddContact');
        $router->post('users/message/templates',           'UserController@msgAddTemplate');

        $router->put('users/{id}',                         'UserController@update');
        $router->put('users/alert/{aid}',                  'UserController@updateAlert');
        $router->put('users/bookmark/{id}',                'UserController@editBookmark');
        $router->put('users/inbox/read/{id}',              'UserController@msgRead');
        $router->put('users/inbox/trash/{id}',             'UserController@msgTrash');
        $router->put('users/message/contacts/{id}',        'UserController@msgUpdateContact');
        $router->put('users/message/templates/{id}',       'UserController@msgUpdateTemplate');

        $router->delete('users/{id}',                      'UserController@destroy');
        $router->delete('users/alert/{aid}',               'UserController@unalert');
        $router->delete('users/badge/{aid}',               'UserController@demerit');
        $router->delete('users/bookmark/{bid}',            'UserController@unbookmark');
        $router->delete('users/inbox/{mid}',               'UserController@mid');
        $router->delete('users/message/contacts/{id}',     'UserController@msgDeleteContact');
        $router->delete('users/message/templates/{id}',    'UserController@msgDeleteTemplate');


        // Organizations
        $router->get('organizations',                         'OrganizationController@index');
        $router->get('organizations/featured',                'OrganizationController@featured');
        $router->post('organizations',                        'OrganizationController@store');
        $router->post('organizations/affiliate',              'OrganizationController@storeAffiliate');
        $router->put('organizations/updateapproval/{id}',     'OrganizationController@updateAffiliateApproval');
        $router->put('organizations/{id}',                    'OrganizationController@update');
        $router->delete('organizations/{id}',                 'OrganizationController@destroy');
        $router->delete('organizations/affiliate/{id}',       'OrganizationController@destroyAffiliate');


        // Profiles
        $router->get('profiles/users',                      'ProfileController@userProfiles');
        $router->get('profiles/employees',                  'ProfileController@employerProfiles');
        $router->get('profiles/schools',                    'ProfileController@schoolProfiles');
        $router->get('profiles/logo/{id}',                  'ProfileController@logo');
        $router->get('profiles/crest/{id}',                 'ProfileController@crest');
        $router->get('profiles/avatar/{id}',                'ProfileController@avatar');
        $router->get('profiles/pic/{id}',                   'ProfileController@pic');
        $router->get('profiles/pdf/{id}',                   'ProfileController@pdf');    
        $router->get('profiles/doc/{id}',                   'ProfileController@doc');    

        $router->post('profiles/users',                     'ProfileController@storeUserProfile');
        $router->post('profiles/users/education',           'ProfileController@storeUserEducation');
        $router->post('profiles/users/primary',             'ProfileController@storeUserPrimary');
        $router->post('profiles/users/club',                'ProfileController@storeUserClub');
        $router->post('profiles/users/experience',          'ProfileController@storeUserExperience');
        $router->post('profiles/users/language',            'ProfileController@storeUserLanguage');
        $router->post('profiles/users/preference',          'ProfileController@storeUserPreference');
        $router->post('profiles/users/resume',              'ProfileController@storeUserResume');
        $router->post('profiles/users/doc',                 'ProfileController@storeUserDoc');
        $router->post('profiles/users/skill',               'ProfileController@storeUserSkill');
        $router->post('profiles/employees',                 'ProfileController@storeEmployerProfile');
        $router->post('profiles/schools',                   'ProfileController@storeSchoolProfile');
        $router->put('profiles/users/{id}',                 'ProfileController@updateUserProfile');
        $router->put('profiles/users/education/{id}',       'ProfileController@updateUserEducation');
        $router->put('profiles/users/primary/{id}',         'ProfileController@updateUserPrimary');
        $router->put('profiles/users/club/{id}',            'ProfileController@updateUserClub');
        $router->put('profiles/users/experience/{id}',      'ProfileController@updateUserExperience');
        $router->put('profiles/users/language/{id}',        'ProfileController@updateUserLanguage');
        $router->put('profiles/users/preference/{id}',      'ProfileController@updateUserPreference');
        $router->put('profiles/users/resume/{id}',          'ProfileController@updateUserResume');
        $router->put('profiles/users/resume/default/{id}',  'ProfileController@updateUserResumeDefault');
        $router->put('profiles/users/doc/{id}',             'ProfileController@updateUserDoc');
        $router->put('profiles/users/skill/{id}',           'ProfileController@updateUserSkill');
        $router->put('profiles/employees/{id}',             'ProfileController@updateEmployerProfile');
        $router->put('profiles/schools/{id}',               'ProfileController@updateSchoolProfile');
        $router->delete('profiles/users/education/{id}',    'ProfileController@destroyUserEducation');
        $router->delete('profiles/users/primary/{id}',      'ProfileController@destroyUserPrimary');    
        $router->delete('profiles/users/club/{id}',         'ProfileController@destroyUserClub');    
        $router->delete('profiles/users/experience/{id}',   'ProfileController@destroyUserExperience');
        $router->delete('profiles/users/language/{id}',     'ProfileController@destroyUserLanguage');
        $router->delete('profiles/users/preference/{id}',   'ProfileController@destroyUserPreference');
        $router->delete('profiles/users/resume/{id}',       'ProfileController@destroyUserResume');
        $router->delete('profiles/users/doc/{id}',          'ProfileController@destroyUserDoc');
        $router->delete('profiles/users/skill/{id}',        'ProfileController@destroyUserSkill');

        // Plans & Contracts
        $router->get('plans',                   'PlanController@index');
        $router->get('contracts',               'PlanController@contracts');
        $router->post('plans',                  'PlanController@store');
        $router->post('plans/contracts',        'PlanController@storeContract');
        $router->put('plans/{id}',              'PlanController@update');
        $router->delete('plans/{id}',           'PlanController@destroy');
        $router->delete('plans/contracts/{id}', 'PlanController@destroyContract');

        // Questionnaires
        $router->get('questionnaires',          'QuestionnaireController@index');
        $router->get('questionnaires/{id}',     'QuestionnaireController@show');
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
        $router->put('themes/{id}',             'ThemeController@update');

        // Templates
        $router->get('templates',                  'TemplateController@index');
        $router->get('templates/default',          'TemplateController@defaultTheme');
        $router->post('templates',                 'TemplateController@store');
        $router->put('templates/{id}',             'TemplateController@update');
        $router->delete('templates/{id}',          'TemplateController@destroy');

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

        $router->get('countries',            'SystemController@countries');
        $router->post('countries',           'SystemController@storeCountry');
        $router->put('countries/{id}',       'SystemController@updateCountry');
        $router->delete('countries/{id}',    'SystemController@destroyCountry');
    
        $router->get('roles',  function() { return \App\Gradlead\Role::all(); });
});
