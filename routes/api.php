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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->group( function () {
//      Route::resource('tanks', 'TanksController');
//  });

// Route::get('/tanks', 'TanksController@index');

// Route::get('/tanks/{id}', 'TanksController@show')->middleware('auth:api');

// Route::post('/tanks', 'TanksController@store')->middleware('auth:api');

// Route::put('/tanks', 'TanksController@update')->middleware('auth:api');

// Route::delete('/tanks', 'TanksController@destroy')->middleware('auth:api');


//Route::resource('/tanks', 'TanksController')->middleware('auth:api');

//test
// Route::get('/tanks/{user}', 'TanksController@index');
Route::get('shrimps/', 'ShrimpsController@index');
// Route::get('shrimps/{id}', 'ShrimpsController@show');
// Route::get('measurements/{id}', 'MesurementController@index');
// Route::post('/measurement', 'MesurementController@store');
// Route::put('/tank/{tank}', 'TanksController@update');
// Route::delete('/measurement/{id}', 'MesurementController@destroy');

Route::prefix('auth')->group(function () {
    // Below mention routes are public, user can access those without any restriction.
    // Create New User
    Route::post('register', 'AuthController@register');
    // Login User
    Route::post('login', 'AuthController@login');

    // Refresh the JWT Token
    Route::get('refresh', 'AuthController@refresh');

    Route::post('reset-password', 'AuthController@sendPasswordResetLink');

    // handle reset password form process
    Route::post('reset/password', 'AuthController@callResetPassword');

    // Below mention routes are available only for the authenticated users.
    Route::middleware('auth:api')->group(function () {
        // Get user info
        Route::get('user', 'AuthController@user');
        // Logout user from application
        Route::post('logout', 'AuthController@logout');

        // Shrimps table
        Route::get('shrimps/', 'ShrimpsController@index');
        Route::get('shrimps/{id}', 'ShrimpsController@show');
        // Tanks table
        Route::get('/tanks/{user}', 'TanksController@index');
        Route::post('/tank', 'TanksController@store');
        Route::put('/tank/{tank}', 'TanksController@update');
        Route::delete('/tank/{tank}', 'TanksController@destroy');
        // measurement table
        Route::get('/measurement/{tank}', 'MesurementController@index');
        Route::post('/measurement', 'MesurementController@store');
        Route::put('/measurement', 'MesurementController@update');
        Route::delete('/measurement/{id}', 'MesurementController@destroy');
    });
});



