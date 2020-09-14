<?php

namespace App\Services;

use App\Models\SurveyUser;
use App\Models\User;
use App\Repositories\User\IUserRepository;

class SurveyService {

    private $userRepo;

    public function __construct(IUserRepository $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function assignToUsers($survey, $users) {

        foreach($users as $user_id) {
            $surveyUser = new SurveyUser;
            $surveyUser->user_id = $user_id;
            $surveyUser->survey_id = $survey->id;
            $surveyUser->save();
        }
    }

    public function assignToAllUsers($survey) {
        
        $users = $this->userRepo->getUsersNotAdmin();
        foreach($users->pluck('id') as $user_id) {
            $surveyUser = new SurveyUser;
            $surveyUser->user_id = $user_id;
            $surveyUser->survey_id = $survey->id;
            $surveyUser->save();
        }
    }

    public function getNotAssignedUsers($survey) {
        
        $users = $this->userRepo->getUsersNotAdmin();
        $surveyUsers = SurveyUser::where('survey_id', $survey->id)->get()->pluck('user_id');
        $users = $users->whereNotIn('id', $surveyUsers);
        return $users->all();
    }
}
