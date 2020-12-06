<?php

namespace App\Models;

use App\Models\User\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SurveyEmployee extends Model
{   
    protected $table = 'survey_employees';
    protected $guarded = [];

    public function survey() 
    {
        return $this->belongsTo(Survey::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'survey_employee_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }
}
