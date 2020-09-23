<?php

namespace App\Http\Controllers\UserEnd;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyUser;
use App\Models\UserAnswers;
use App\Repositories\Survey\ISurveyRepository;
use App\Repositories\User\IUserRepository;
use App\Requests\SurveyRequest;
use App\Services\SurveyService;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    private $dir = 'user-end.survey.';
    private $surveyRepo;
    private $userRepo;
    private $surveyService;

    public function __construct(
        ISurveyRepository $surveyRepo, 
        IUserRepository $userRepo,
        SurveyService $surveyService
    ) {
        $this->surveyRepo = $surveyRepo;
        $this->userRepo = $userRepo;
        $this->surveyService = $surveyService;
    }

    public function startSurvey($uuid) {
        $survey = Survey::full()->where('uuid', $uuid)->first();
        if($survey->type == 'private' || !$survey->isPublished()) {
            return 'Access denied';
        }
        session(['taken_survey' => $survey]);
        return view($this->dir . 'start', compact('survey'));
    }

    public function submitStartSurvey(Request $request, $uuid) {
        
        $request->validate([
            'user.username' => 'required',
            'user.email' => ['required', 'email', 'unique:users,email'],
            'user.phone_number' => 'required'
        ]);
        $data = $request->user;
        $data['ip'] = getIPAddress();
        
        $survey = session('taken_survey');
            
        // save user info
        session(['user' => $data]);

        // initialize questions in session to be ready to store the answerd questions
        session(['questions_list' => Survey::full()->find($survey->id)->questions]);
        session(['answerd_questions' => []]);
        session(['index' => 0]);

        return redirect()->route('inProgressSurvey', $uuid);
    }

    public function inProgressSurvey(Request $request, $uuid) {
        $index      = session('index');
        $survey     = session('taken_survey');
        $question   = session('questions_list')[$index];
        return view($this->dir . 'answering', compact('survey', 'question'));
    }
    
    public function submitInProgressSurvey(Request $request, $uuid) {
        // dd(
        //     $request->all(),
        //     !($request->question['answer'] ?? false) &&
        //     !($request->question['answers'] ?? false)
        // );
        $index              = session('index');
        $survey             = session('taken_survey');
        $questions_list     = session('questions_list');
        $question           = session('questions_list')[$index];
        $answerdQuestion    = $request->question;
        
        // 1- check if the uuid have no changes in URL
        // 2- check if the question id is not exist
        if(
            $survey->uuid != $uuid ||
            $question->id != $answerdQuestion['id']
        ) {
            return redirect()->back()->with('status', [
                'type' => 'error',
                'msg' => 'Do not mess, please'
            ]);
        }

        // validate required question
        if(
            !($request->question['answer'] ?? false) &&
            !($request->question['answers'] ?? false)
        ) {
            if($question->required == 1) {
                return redirect()->back()->with('status', [
                    'type' => 'error',
                    'msg' => 'The questions is required'
                ]);
            }
        } else {
            // check if the answer is not modified by the user
            if($question->type == 'checkbox') {
    
                // remove the deplicated values if someone want duplicate the data
                $answerdQuestion['answers'] = array_unique($answerdQuestion['answers']);
    
                $check = true;
                foreach($answerdQuestion['answers'] as $answer) {
                    if(!$question->answers->contains('body', $answer)) {
                        $check = false;
                        break;
                    }
                }
                if($check == false) {
                    return redirect()->back()->with('status', [
                        'type' => 'error',
                        'msg' => 'Do not mess, please'
                    ]);
                }
            } elseif($question->type == 'radio') {
                if(
                    !$question->answers->contains('body', $answerdQuestion['answer']) &&
                    !$question->answers->contains('body', 'other')
                ) {
                    return redirect()->back()->with('status', [
                        'type' => 'error',
                        'msg' => 'Do not mess, please'
                    ]);
                }
            }
            
            // add the answerd question to the list
            session()->push('answerd_questions', $answerdQuestion);
    
            // rebuild the questions list
            $this->rebuildQuestionsList();
        }

        $index = session('index');
        $index++;
        session(['index' => $index]);

        if($index >= count(session('questions_list'))) {
            // submit and finish the survey
            $this->submitSurvey();
            return redirect()->route('finishSurvey');
        }
        
        return redirect()->route('inProgressSurvey', $uuid);
    }

    public function previousQuestion(Request $request, $uuid) {
        $index = session('index');
        if($index == 0) {
            return redirect()->route('startSurvey', $uuid);
        }

        // remove the last answerd question
        $answerdQuestions = session('answerd_questions');
        array_pop($answerdQuestions);
        session(['answerd_questions' => $answerdQuestions]);
        
        $index--;
        session(['index' => $index]);

        return redirect()->route('inProgressSurvey', $uuid);
    }

    public function finishSurvey() {
        return view($this->dir . 'finish')->with('status', [
            'type' => 'success',
            'msg' => 'Thansk for completing the survey'
        ]);
    }

    private function submitSurvey() {
        $user = session('user');
        $survey = session('taken_survey');
        $answerd_questions = session('answerd_questions');
        
        // check if this user is exist of not
        $oldUser = $this->userRepo->findByEmail($user['email']);
        if(!$oldUser) {
            $user = $this->userRepo->create([
                'name' => $user['username'],
                'email' => $user['email'],
                'phone_number' => $user['phone_number'],
                'ip' => $user['ip']
            ]);
        } else {
            $user = $oldUser;
        }

        // create new surveyUser
        $surveyUser = new SurveyUser;
        $surveyUser->user_id = $user->id;
        $surveyUser->survey_id = $survey->id;
        $surveyUser->status = SurveyUser::COMPLETED;
        $surveyUser->save();

        // create answerd questions
        foreach($answerd_questions as $answerd_question) {
            $userAnswers = new UserAnswers;
            $userAnswers->survey_user_id = $surveyUser->id;
            $userAnswers->question_id = $answerd_question['id'];
            if($answerd_question['answers'] ?? false) {
                $userAnswers->response = json_encode($answerd_question['answers']);
            } else  {
                $userAnswers->response = $answerd_question['answer'];
            }
            $userAnswers->save();
        }

        session()->forget([
            'index', 
            'questions_list',
            'answerd_questions',
            'taken_survey',
            'user'
        ]);
    }

    private function rebuildQuestionsList() {
        $survey = session('taken_survey');
        $questions_list = Survey::full()->find($survey->id)->questions;
        $answerdQuestions = session('answerd_questions');
        
        foreach($questions_list as $key => $question) {
            $q = searchInArray($answerdQuestions, 'id', $question->id);

            if($question->type == 'radio' && $q != null) {
                $dependentQuestions = [];
                foreach($question->answers as $answer) {
                    if($q['answer'] == $answer->body) {
                        $dependentQuestions = $answer->dependentQuestions;
                    }
                }
                // add the dependentQuestions to the current questions list
                if(count($dependentQuestions) > 0) {
                    $descendants = $this->addDescendants($dependentQuestions, $answerdQuestions);
                    $questions_list->splice($key + 1, 0, $descendants);
                }
            }
        }

        session(['questions_list' => $questions_list]);
    }

    private function addDescendants($questions, $answerdQuestions) {
        $resArray = [];
        foreach($questions as $question) {
            $resArray[] = $question;
            $q = searchInArray($answerdQuestions, 'id', $question->id);
    
            if($question->type == 'radio' && $q != null) {
                $dependentQuestions = [];
                foreach($question->answers as $answer) {
                    if($q['answer'] == $answer->body) {
                        $dependentQuestions = $answer->dependentQuestions;
                    }
                }
                if(count($dependentQuestions) > 0) {
                    $resArray = array_merge(
                        $resArray,
                        $this->addDescendants($dependentQuestions, $answerdQuestions)
                    );
                }
            }
        }
        return $resArray;
    }
}
