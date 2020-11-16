<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $with = ['answers', 'children'];

    // Question types
    const TYPES = ['text', 'radio', 'checkbox', 'time', 'date', 'textarea', 'range', 'file'];
    const TYPES_MAP = [
        'radio' => 'radio',
        'checkbox' => 'checkbox',
        'text' => 'text',
        'longtext' => 'textarea',
        'location' => 'text',
        'image' => 'file',
        'time' => 'time',
        'date' => 'date',
        'range' => 'range',
    ];

    public static function getTypes() {
        return Question::TYPES;
    }
    
    public static function getTypesKeys() {
        return array_keys(Question::TYPES_MAP);
    }

    public static function getTypesValues() {
        return array_values(Question::TYPES_MAP);
    }

    public function getType() {
        return Question::TYPES_MAP[$this->type];
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
