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

        $router->get('/',     'WelcomeController@index');
        $router->get('/home', 'HomeController@index');

        // Routes
        $router->get('badges',       'BadgeController@index');
        $router->post('badges',      'BadgeController@store');
        $router->put('badges/{id}',  'BadgeController@update');
        $router->delete('badges/{id}',  'BadgeController@destroy');

        $router->get('users',          'UserController@index');
        $router->post('users',         'UserController@store');
        $router->put('users/{id}',     'UserController@update');
        $router->delete('users/{id}',  'UserController@destroy');

        $router->get('organizations',               'OrganizationController@index');
        $router->post('organizations',              'OrganizationController@store');
        $router->post('organizations/addaffiliate', 'OrganizationController@storeAffiliate');
        $router->put('organizations/{id}',  'OrganizationController@update');
        $router->delete('organizations/{id}',  'OrganizationController@destroy');

        $router->get('roles',  function() { return \App\Gradlead\Role::all(); });
});

