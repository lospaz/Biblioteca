<?php

/*
|--------------------------------------------------------------------------
| Module Api Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['api', 'jwt.auth'], 'prefix' => 'library', 'namespace' => 'API'], function (){

    Route::get('/books', 'BookController@index');

    Route::group(['middleware' => 'permission:library.create'], function (){
        Route::post('/books', 'BookController@store');
    });

});