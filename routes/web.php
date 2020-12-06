<?php

use App\Models\Question;
use App\Models\ResponsesView;
use App\Models\Survey;
use App\Models\SurveyUser;
use App\Models\User;
use App\Models\User\Employee;
use App\Models\User\Standard;
use App\Models\UserAnswers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    'namespace' => 'Dashboard\Auth',
    'as' => 'dashboard.auth.'
], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('showLoginForm');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
});

// Dashboard
Route::group([
    'middleware' => 'auth',
    'prefix' => 'dashboard',
    'namespace' => 'Dashboard',
    'as' => 'dashboard.'
], function () {
    
    Route::get('/', 'DashboardController@index')->name('home');
    Route::resource('user', 'UserController');
    Route::resource('group', 'GroupController');
    Route::resource('role', 'RoleController');
    Route::resource('admin', 'AdminController');
    Route::resource('question', 'QuestionController');
    Route::resource('answer', 'AnswerController');
    
    Route::get('survey/{survey}/assign', 'SurveyController@assignToEmployeePage')
        ->name('survey.assignPage');
    Route::post('survey/{survey}/assign', 'SurveyController@assignToEmployees')
        ->name('survey.assign');
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

    // Submissions Stuff
    Route::get(
        'submission/exportSurveyByUser/{survey_id}/{user_id}', 
        'SubmissionController@exportSurveyByUser'
    )->name('submission.exportSurveyByUser');
    Route::get(
        'submission/exportSurvey/{survey_id}', 
        'SubmissionController@exportSurvey'
    )->name('submission.exportSurvey');
    Route::get(
        'submission/exportAllSurveys', 
        'SubmissionController@exportAllSurveys'
    )->name('submission.exportAllSurveys');
    Route::resource('submission', 'SubmissionController')->only(['index', 'show', 'destroy']);

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
});

// Take Survey Stuff
Route::group(['namespace' => 'Front'], function () {
    Route::get('startSurvey/{uuid}', 'SurveyController@startSurvey')->name('startSurvey');
    Route::post('startSurvey/{uuid}', 'SurveyController@submitStartSurvey')->name('submitStartSurvey');
    Route::get('inProgressSurvey/{uuid}', 'SurveyController@inProgressSurvey')->name('inProgressSurvey');
    Route::post('inProgressSurvey/{uuid}', 'SurveyController@submitInProgressSurvey')->name('submitInProgressSurvey');
    Route::post('previousQuestion/{uuid}', 'SurveyController@previousQuestion')->name('previousQuestion');
    Route::get('finishSurvey', 'SurveyController@finishSurvey')->name('finishSurvey');
});

Route::get('test', function () {
    dd('done');
});
