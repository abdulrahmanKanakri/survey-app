<?php

use App\Models\Question;
use App\Models\ResponsesView;
use App\Models\Survey;
use App\Models\User;
use Carbon\Carbon;
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

Route::get('/', function () {
    return redirect()->route('dashboard.home');
});

// Auth
Route::group([
    'prefix' => 'dashboard/auth',
    'namespace' => 'auth',
    'as' => 'dashboard.auth.'
], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('showLoginForm');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
});

// Take Survey Stuff
Route::group(['namespace' => 'UserEnd'], function () {
    Route::get('startSurvey/{uuid}', 'SurveyController@startSurvey')->name('startSurvey');
    Route::post('startSurvey/{uuid}', 'SurveyController@submitStartSurvey')->name('submitStartSurvey');
    Route::get('inProgressSurvey/{uuid}', 'SurveyController@inProgressSurvey')->name('inProgressSurvey');
    Route::post('inProgressSurvey/{uuid}', 'SurveyController@submitInProgressSurvey')->name('submitInProgressSurvey');
    Route::post('previousQuestion/{uuid}', 'SurveyController@previousQuestion')->name('previousQuestion');
    Route::get('finishSurvey', 'SurveyController@finishSurvey')->name('finishSurvey');
});

// Dashboard
Route::group([
    'middleware' => 'auth',
    'prefix' => 'dashboard',
    'as' => 'dashboard.'
], function () {
    
    Route::get('/', 'DashboardController@index')->name('home');
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    
    Route::resource('question', 'QuestionController');
    Route::resource('answer', 'AnswerController');
    
    Route::get('survey/{survey}/assign', 'SurveyController@assignToUsersPage')->name('survey.assignPage');
    Route::post('survey/{survey}/assign', 'SurveyController@assignToUsers')->name('survey.assign');
    Route::resource('survey', 'SurveyController');
    Route::resource('survey.question', 'SurveyQuestionController');

    // Responses Stuff
    Route::get(
        'response/exportSurveyByUser/{survey_id}/{user_id}', 
        'ResponseController@exportSurveyByUser'
    )->name('response.exportSurveyByUser');
    Route::get(
        'response/exportSurvey/{survey_id}', 
        'ResponseController@exportSurvey'
    )->name('response.exportSurvey');
    Route::get(
        'response/exportAllSurveys', 
        'ResponseController@exportAllSurveys'
    )->name('response.exportAllSurveys');
    Route::resource('response', 'ResponseController')->only(['index', 'show', 'destroy']);
});

// Ajax
Route::group([
    'prefix' => 'ajax',
    'as' => 'ajax.'
], function () {
    Route::post('createAnswer', 'AnswerController@createAnswer')->name('createAnswer');
    Route::post('cerateMultipleAnswers', 'AnswerController@cerateMultipleAnswers')
        ->name('cerateMultipleAnswers');
    Route::post('editAnswer/{id}', 'AnswerController@editAnswer')->name('editAnswer');
    Route::post('deleteAnswer/{id}', 'AnswerController@deleteAnswer')->name('deleteAnswer');
});

Route::get('test', function () {
    dd(json_decode(3124));
    dd('done');
});
