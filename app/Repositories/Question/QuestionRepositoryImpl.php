<?php

namespace App\Repositories\Question;

use App\Models\Question;

class QuestionRepositoryImpl implements IQuestionRepository {

    public function getQuestions($limit) {
        return Question::with('survey', 'answers')->paginate($limit);
    }
    
    public function getQuestionById($id) {
        return Question::with('survey', 'answers')->find($id);
    }
    
    public function getTypes() {
        return Question::getTypes();
    }

    public function all() {
        return Question::all();
    }

    public function updateOrCreate($data, $id = null) {
        $question = $id == null ? new Question : Question::find($id);
        $question->title = $data['title'];
        $question->type = $data['type'];
        $question->required = intval($data['required']);
        $question->survey_id = $data['survey_id'];
        $question->dependent_question_id = $data['dependent_question_id'];
        $question->dependent_answer_id = $data['dependent_answer_id'];
        $question->save();
        return $question;
    }
    
    public function delete($id) {
        Question::find($id)->delete();
    }
}