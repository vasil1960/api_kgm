<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'SearchController@allkgm');

Route::group(['prefix'=>'api'], function() {
//    Route::resource('kgm','KgmController');

    Route::get('kgm/allkgm/',['as'=>'api.kgm.allkgm','uses'=>'SearchController@allkgm']);

    Route::get('kgm/bynumb/{seria}/{number}',['as'=>'api.kgm.bynumb','uses'=>'SearchController@bynumb']);
});
