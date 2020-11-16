<?php

namespace App\Services;

class QuestionService {
    
    public function getMappedQuestion($data, $survey_id) {
        return [
            'title' => $data['question_title'],
            'type' => $data['question_type'],
            'required' => $data['question_required'],
            'survey_id' => $survey_id,
            'dependent_question_id' => $data['based_question'] ?? null,
            'dependent_answer_id' => $data['based_answer'] ?? null,
        ];
    }
}
