<?php

/*
|--------------------------------------------------------------------------
| Module Web Routes
|--------------------------------------------------------------------------
*/
Route::group(['domain' => config('app.normalurl')], function () {

    Route::resource('/library', 'LibraryController');

    Route::group(['middleware' => 'auth', 'prefix' => 'library/loan'], function (){

        Route::get('/my', 'LoanController@index')->name('library.loan');

        Route::group(['middleware' => 'permission:library.loan'], function (){
            Route::get('/{id}', 'LoanController@loan')->name('library.loan.index');
            Route::post('/{id}', 'LoanController@store')->name('library.loan.store');

            Route::get('/search/users', 'LoanController@search')->name('library.loan.search');
        });

    });

});