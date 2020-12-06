<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => 'Api\Auth',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group([
    'namespace' => 'Api',
    'middleware' => ['auth:api', 'employee'],
    'prefix' => 'employee'
], function () {
    Route::get('get-my-surveys', 'EmployeeController@getMySurveys');
    Route::get('start-survey/{id}', 'EmployeeController@startSurvey');
    Route::post('submit-survey/{id}', 'EmployeeController@submitSurvey');
});

Route::group([
    'namespace' => 'Api',
    'middleware' => ['auth:api', 'standard'],
    'prefix' => 'standard'
], function () {
    Route::get('get-available-surveys', 'StandardController@getAvailableSurveys');
    Route::get('get-my-surveys', 'StandardController@getMySurveys');
    Route::get('start-survey/{id}', 'StandardController@startSurvey');
    Route::post('submit-survey/{id}', 'StandardController@submitSurvey');
    Route::put('update-profile', 'StandardController@updateProfile');
    Route::get('show-profile', 'StandardController@showProfile');
});

Route::group([
    'namespace' => 'Api',
    'middleware' => ['auth:api'],
    'prefix' => 'media',
], function () {
    Route::post('store-file', 'MediaController@storeFile');
    Route::post('store-multiple-files', 'MediaController@storeMultipleFiles');
});
