<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');

});
	//Client
    Route::get('/client', 'ClientController@index');
    Route::post('/client', 'ClientController@store');
    Route::put('/client/{id}', 'ClientController@update');
    Route::get('/client/{id}', 'ClientController@show');
    Route::delete('/client/{id}', 'ClientController@destroy');
    //Project

    Route::get('/project/{id}/note', 'ProjectNoteController@index');
    Route::post('/project/{id}/note', 'ProjectController@store');
    Route::get('/project/{id}/note/{noteId}', 'ProjectNoteController@show');
    Route::put('/project/{id}/note/{noteId}', 'ProjectController@update');
    Route::delete('/project/{id}/note/{noteId}', 'ProjectController@destroy');

    Route::get('/project', 'ProjectController@index');
    Route::post('/project', 'ProjectController@store');
    Route::put('/project/{id}', 'ProjectController@update');
    Route::get('/project/{id}', 'ProjectController@show');
    Route::delete('/project/{id}', 'ProjectController@destroy');

    Route::post('oauth/access_token', function(){
    	return Response::json(Authorizer::issueAccessToken());
    });
