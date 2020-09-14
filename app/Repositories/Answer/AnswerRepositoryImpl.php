<?php

namespace App\Repositories\Answer;

use App\Models\Answer;

class AnswerRepositoryImpl implements IAnswerRepository {

    public function getAnswers($limit) {
        return Answer::with('question')->paginate($limit);
    }
    
    public function getAnswerById($id) {
        return Answer::with('question')->find($id);
    }

    public function all() {
        return Answer::all();
    }
    
    public function updateOrCreate($data, $id = null) {
        $answer = $id == null ? new Answer : Answer::find($id);
        $answer->body = $data['body'];
        $answer->question_id = $data['question_id'];
        $answer->save();
        return $answer;
    }
    
    public function delete($id) {
        Answer::find($id)->delete();
    }
}