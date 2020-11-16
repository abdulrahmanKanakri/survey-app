<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    protected static function booted()
    {
        static::addGlobalScope('ordering', function(Builder $builder) {
            return $builder->orderBy('ordering');
        });
    }
}
