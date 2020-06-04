<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    
    // Answer types
    public static $types = ['text', 'radio', 'checkbox', 'textarea'];
    const TEXT = 'text';
    const RADIO = 'radio';
    const CHECKBOX = 'checkbox';
    const TEXTAREA = 'textarea';

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public static function getTypes() {
        return Answer::$types;
    }
}
