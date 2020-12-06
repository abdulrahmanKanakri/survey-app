<?php

namespace App\Models;

use App\Models\User\Standard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SurveyUser extends Model
{   
    protected $table = 'survey_user';
    protected $guarded = [];

    public function survey() 
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function user()
    {
        return $this->belongsTo(Standard::class, 'user_id');
    }

    public function userAnswers()
    {
        return $this->morphMany(UserAnswers::class, 'model');
    }

    public function scopewithAll(Builder $builder) {
        return $builder->with('user', 'survey', 'userAnswers');
    }
}
