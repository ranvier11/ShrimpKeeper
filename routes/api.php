<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->group( function () {
//      Route::resource('tanks', 'TanksController');
//  });

Route::get('/tanks', 'TanksController@index')->middleware('auth:api');

Route::get('/tanks/{id}', 'TanksController@show')->middleware('auth:api');

Route::post('/tanks', 'TanksController@store')->middleware('auth:api');

Route::put('/tanks', 'TanksController@update')->middleware('auth:api');

Route::delete('/tanks', 'TanksController@destroy')->middleware('auth:api');


//Route::resource('/tanks', 'TanksController')->middleware('auth:api');
