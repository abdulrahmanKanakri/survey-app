<?php

namespace App\Services;

use App\Models\Group;
use App\Models\SurveyEmployee;
use App\Models\SurveyUser;
use App\Models\User;
use App\Models\User\Employee;
use App\Repositories\User\IUserRepository;
use Illuminate\Support\Facades\DB;

class SurveyService 
{
    public function assignToEmployees($survey, $data) {
        $group_user = DB::table('group_user')
            ->select('user_id')
            ->distinct()
            ->whereIn('group_id', $data['groups'])
            ->pluck('user_id')
            ->merge($data['employees'] ?? [])
            ->toArray();
        
        $employees = Employee::with('surveys')->find($group_user);
        foreach($employees as $employee) {
            if(!$employee->surveys->contains('survey_id', $survey->id)) {
                $this->assignToEmployee($survey, $employee, $data);
            }
        }
    }

    private function assignToEmployee($survey, $employee, $data) {
        $surveyEmployee = new SurveyEmployee;
        $surveyEmployee->survey_id       = $survey->id;
        $surveyEmployee->user_id         = $employee->id;
        $surveyEmployee->target          = $data['target'];
        $surveyEmployee->due_date        = $data['due_date'] ?? null;
        $surveyEmployee->sub_target      = $data['sub_target'] ?? null;
        $surveyEmployee->sub_target_type = $data['sub_target_type'] ?? null;
        $surveyEmployee->notes           = $data['notes'] ?? null;
        $surveyEmployee->save();
    }

    public function getNotAssignedEmployees($survey) {
        $ids = SurveyEmployee::select('user_id')->where('survey_id', $survey->id)->get();
        $employees = Employee::whereNotIn('id', $ids)->get();
        return $employees;
    }
}
