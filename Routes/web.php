<?php

/*
|--------------------------------------------------------------------------
| Module Web Routes
|--------------------------------------------------------------------------
*/

Route::resource('/library', 'LibraryController');

Route::group(['middleware' => 'auth', 'prefix' => 'library/loan'], function (){

    Route::get('/my', 'LoanController@index')->name('library.loan');

    Route::get('/{id}', 'LoanController@loan')->name('library.loan.index');
    Route::post('/{id}', 'LoanController@store')->name('library.loan.store');

});