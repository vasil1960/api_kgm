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

    Route::get('kgm/all/',['as'=>'api.kgm.all','uses'=>'SearchController@all']);

    Route::get('kgm/bySerNumb/{seria}/{number}',['as'=>'api.kgm.sernumb','uses'=>'SearchController@bySerNumb']);

    Route::get('kgm/byname/{ime}/{familia}',['as'=>'api.kgm.byname','uses'=>'SearchController@byname']);
});
