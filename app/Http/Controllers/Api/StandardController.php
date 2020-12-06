<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyUser;
use App\Models\User\Profile;
use App\Models\User\User;
use App\Models\UserAnswers;
use App\Requests\ProfileRequest;

class StandardController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = standard();
    }

    public function showProfile()
    {
        return ApiResponse::success($this->user->load('profile'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        $profile = Profile::updateOrCreate(
            ['user_id' => $this->user->id],
            [
                'gender'         => $request->gender,
                'age'            => $request->age,
                'birth_date'     => $request->birth_date,
                'address'        => $request->address,
                'nationality'    => $request->nationality,
                'marital_status' => $request->marital_status,
            ]
        );
        return ApiResponse::success($this->user->load('profile'), 'Successfully updated');
    }

    public function getAvailableSurveys()
    {
        $completedSurveys = SurveyUser::select('survey_id')
            ->where('user_id', $this->user->id)
            ->get();
        $surveys = Survey::public()->whereNotIn('id', $completedSurveys)->get();
        return ApiResponse::success($surveys, 'Successfully loaded');
    }

    public function getMySurveys()
    {
        $completedSurveys = SurveyUser::select('survey_id')
            ->where('user_id', $this->user->id)
            ->get();
        $surveys = Survey::public()->whereNotIn('id', $completedSurveys)->get();
        $completedSurveys = Survey::public()->whereIn('id', $completedSurveys)->get();
        return ApiResponse::success([
            'available' => $surveys,
            'completed' => $completedSurveys
        ], 'Successfully loaded');
    }

    public function startSurvey(Request $request, $id)
    {
        $survey = Survey::public()->with('questions.answers')->find($id);
        if($survey == null) {
            return ApiResponse::error(
                ['error' => 'Forbidden'], 
                'Access denied, this survey is not available for you', 
                403
            );
        }
        return ApiResponse::success($survey);
    }

    public function submitSurvey(Request $request, $id)
    {
        // TODO: check if the required questions get answered

        // return ApiResponse::success($request->all());
        $survey = Survey::public()->find($id);
        if($survey == null) {
            return ApiResponse::error(
                ['error' => 'Forbidden'], 
                'Access denied, this survey is not available for you', 
                403
            );
        }

        // create survey_user
        // loop through the answered_questions and create user_answer
        
        $surveyUser = new SurveyUser;
        $surveyUser->survey_id = $id;
        $surveyUser->user_id = $this->user->id;
        $surveyUser->save();
        
        $answered_questions = $request->answered_questions;
        foreach($answered_questions as $question) {
            $userAnswer = new UserAnswers;
            $userAnswer->question_id = $question['question_id'];
            if(is_array($question['value'])) {
                $userAnswer->response = json_encode($question['value']);
            } else {
                $userAnswer->response = $question['value'];
            }
            $surveyUser->userAnswers()->save($userAnswer);
        }
        
        return ApiResponse::success(null, 'Successfully submitted');
    }
}
