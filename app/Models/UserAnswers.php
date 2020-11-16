<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswers extends Model
{
    protected $table = 'user_answers';
    protected $guarded = [];
    public $timestamps = false;

    // public function surveyUser()
    // {
    //     return $this->belongsTo(SurveyUser::class, 'survey_user_id');
    // }

    public function model()
    {
        return $this->morphTo();
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
