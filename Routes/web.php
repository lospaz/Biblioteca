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

    Route::group(['middleware' => 'role:admin'], function (){
        Route::get('/{id}/external', 'LoanController@extLoan')->name('library.loan.index.ext');
        Route::post('/{id}/external', 'LoanController@extStore')->name('library.loan.store.ext');
    });
});