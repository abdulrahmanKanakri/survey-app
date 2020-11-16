<?php

namespace App\Repositories\Survey;

use App\Models\Survey;
use App\Services\SurveyService;

class SurveyRepositoryImpl implements ISurveyRepository {

    private $surveyService;

    public function __construct(SurveyService $surveyService) {
        $this->surveyService = $surveyService;
    }

    public function getSurveys($limit) {
        return Survey::with('questions')->paginate($limit);
    }
    
    public function getSurveyById($id) {
        return Survey::with('questions.answers')->find($id);
    }

    public function all() {
        return Survey::all();
    }
    
    public function create($data) {
        $survey = new Survey();
        $survey->title = $data['title'];
        $survey->description = $data['description'];
        $survey->type = $data['type'];
        if($data['publish_date']) $survey->publish_date = $data['publish_date'];
        if($data['due_date']) $survey->due_date = $data['due_date'];
        $survey->uuid = \Str::uuid();
        $survey->save();
        return $survey;
    }
    
    public function update($data, $id) {
        $survey = Survey::find($id);
        $survey->title = $data['title'];
        $survey->description = $data['description'];
        $survey->type = $data['type'];
        $survey->publish_date = $data['publish_date'];
        $survey->due_date = $data['due_date'];
        $survey->save();
    }
    
    public function delete($id) {
        Survey::find($id)->delete();
    }
}