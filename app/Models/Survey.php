<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{

    const TYPES = ['private', 'public'];

    protected $table = 'surveys';

    public function questions()
    {
        return $this->hasMany(Question::class, 'survey_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'survey_user', 'survey_id', 'user_id');
    }

    public function getColor() {
        return $this->type == 'private' ? 'danger' : 'primary';
    }

    public function scopeFull(Builder $builder) {
        return $builder->with([
            'questions' => function($q) {
                return $q->whereNull('dependent_question_id');
            }
        ]);
    }

    public function scopePublished(Builder $builder) {
        return $builder->where('publish_date', '<=', getCurrentDate());
    }

    public function isPublished() {
        return $this->publish_date <= getCurrentDate();
    }

    public function getPublishDate($format = 'Y-m-d') {
        return Carbon::parse($this->publish_date)->format($format);
    }
}
