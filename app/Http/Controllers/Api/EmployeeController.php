<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Survey;
use App\Models\SurveyEmployee;
use App\Models\User\Employee;
use App\Models\User\User;
use App\Models\UserAnswers;

class EmployeeController extends Controller
{
    private $employee;

    public function __construct() {
        $this->employee = employee();
    }

    public function getMySurveys()
    {
        $surveys = $this->employee->surveys; // get the survey details
        return ApiResponse::success($surveys, 'Successfully loaded');
    }

    public function startSurvey(Request $request, $id)
    {
        $surveyEmployee = SurveyEmployee::where('survey_id', $id)
            ->where('user_id', $this->employee->id)
            ->first();
        if($surveyEmployee == null) {
            return ApiResponse::error(
                ['error' => 'Forbidden'], 
                'Access denied, this survey is not available for you', 
                403
            );
        }
        $survey = Survey::full()->find($id);
        return ApiResponse::success($survey);
    }

    public function submitSurvey(Request $request, $id)
    {
        // create new submission
        // link the submission with the survey_employee
        // loop through the answered questions and create user_answer 
        // and link it with the submission

        $surveyEmployee = SurveyEmployee::where('survey_id', $id)
            ->where('user_id', $this->employee->id)
            ->first();
        if($surveyEmployee == null) {
            return ApiResponse::error(
                ['error' => 'Forbidden'], 
                'Access denied, this survey is not available for you', 
                403
            );
        }

        $submission = new Submission;
        $submission->survey_employee_id = $surveyEmployee->id;
        $submission->save();

        $answered_questions = $request->answered_questions;
        foreach($answered_questions as $question) {
            $userAnswer = new UserAnswers;
            $userAnswer->question_id = $question['question_id'];
            if(is_array($question['value'])) {
                $userAnswer->response = json_encode($question['value']);
            } else {
                $userAnswer->response = $question['value'];
            }
            $submission->userAnswers()->save($userAnswer);
        }
        
        return ApiResponse::success(null, 'Successfully submitted');
    }
}
