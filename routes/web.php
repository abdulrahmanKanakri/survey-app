<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'dashboard'], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('survey', 'SurveyController');
    Route::resource('question', 'QuestionController');
    Route::resource('answer', 'AnswerController');

    Route::group([
        'prefix' => 'survey/{id}/question',
        'as' => 'survey.question.'
    ], function () {
        Route::get('/create', 'SurveyController@createQuestion')->name('create');
        Route::post('/store', 'SurveyController@storeQuestion')->name('store');
        
    });
});

Route::get('/', function () {
    return view('welcome');
});
