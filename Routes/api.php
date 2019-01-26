<?php

/*
|--------------------------------------------------------------------------
| Module Api Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['api', 'jwt.auth'], 'prefix' => 'library', 'namespace' => 'API'], function (){

    /**
     * Books
     */
    Route::get('/books', 'BookController@index');

    Route::get('/books/{id}', 'BookController@show');

    Route::group(['middleware' => 'permission:library.create'], function (){
        Route::post('/books', 'BookController@store');
    });

    Route::group(['middleware' => 'permission:library.edit'], function (){
        Route::put('/books/{id}', 'BookController@update');
    });

    Route::group(['middleware' => 'permission:library.delete'], function (){
        Route::delete('/books/{id}', 'BookController@delete');
    });

    /**
     * Categories
     */
    Route::get('/categories', 'CategoryController@index');

});