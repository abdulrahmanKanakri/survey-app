<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $with = ['answers', 'children'];

    // Question types
    const TYPES = ['text', 'radio', 'checkbox', 'time', 'date', 'textarea', 'range'];

    public static function getTypes() {
        return Question::TYPES;
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function children() {
        return $this->hasMany(Question::class, 'dependent_question_id');
    }

    public function dependentQuestion() {
        return $this->belongsTo(Question::class, 'dependent_question_id');
    }

    public function dependentAnswer() {
        return $this->belongsTo(Answer::class, 'dependent_answer_id');
    }
}
