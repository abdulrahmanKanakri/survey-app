<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function dependentQuestions() {
        return $this->hasMany(Question::class, 'dependent_answer_id');
    }
}
