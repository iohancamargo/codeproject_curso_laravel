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
    return view('app');
});


// Route::group(['middleware' => 'web'], function () {
//     Route::auth();

//     Route::get('/home', 'HomeController@index');

// });


Route::post('oauth/access_token', function(){
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function(){

    //Deixando as rotas limpas
    Route::resource('client', 'ClientController',['except' =>['create','edit']]);

    Route::group(['middleware' => 'CheckProjectOwner'], function(){

        Route::resource('project', 'ProjectController',['except' =>['create','edit']]);
    });

    Route::group(['prefix' => 'project'],function(){

        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::post('{id}/note', 'ProjectNoteController@store');
        Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
        Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
        Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');    
        
        Route::post('{id}/file','ProjectFileController@store');
    });
    //Client
    // Route::get('/client', ['middleware' => 'oauth','uses' => 'ClientController@index']);
    // Route::post('/client', 'ClientController@store');
    // Route::put('/client/{id}', 'ClientController@update');
    // Route::get('/client/{id}', 'ClientController@show');
    // Route::delete('/client/{id}', 'ClientController@destroy');
    // // Project    
    // Route::get('/project', 'ProjectController@index');
    // Route::post('/project', 'ProjectController@store');
    // Route::put('/project/{id}', 'ProjectController@update');
    // Route::get('/project/{id}', 'ProjectController@show');
    // Route::delete('/project/{id}', 'ProjectController@destroy');
    //Project Note
    // Route::get('/project/{id}/note', 'ProjectNoteController@index');
    // Route::post('/project/{id}/note', 'ProjectNoteController@store');
    // Route::get('/project/{id}/note/{noteId}', 'ProjectNoteController@show');
    // Route::put('/project/{id}/note/{noteId}', 'ProjectNoteController@update');
    // Route::delete('/project/{id}/note/{noteId}', 'ProjectNoteController@destroy');

});


