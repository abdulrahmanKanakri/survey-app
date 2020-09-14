<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SurveyUser extends Model
{
    const STATUSES = ['available', 'completed'];
    const AVAILABLE = 'available';
    const COMPLETED = 'completed';
    
    protected $table = 'survey_user';

    public function survey() {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userAnswers() {
        return $this->hasMany(UserAnswers::class, 'survey_user_id');
    }

    public function scopewithAll(Builder $builder) {
        return $builder->with('user', 'survey', 'userAnswers');
    }
}
