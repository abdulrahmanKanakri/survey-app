<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{   
    protected $table = 'submissions';
    protected $guarded = [];

    public function surveyEmployee()
    {
        return $this->belongsTo(SurveyEmployee::class, 'survey_employee_id');
    }
    
    public function userAnswers()
    {
        return $this->morphMany(UserAnswers::class, 'model');
    }

    public function scopeWithAll(Builder $builder)
    {
        return $builder->with(['surveyEmployee', 'userAnswers']);
    }
}
