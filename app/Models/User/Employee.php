<?php

namespace App\Models\User;

use App\Models\Group;
use App\Models\Survey;
use App\Models\SurveyEmployee;
use Illuminate\Database\Eloquent\Builder;

class Employee extends User
{
    protected $attributes = ['role' => self::EMPLOYEE];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('employee', function (Builder $builder) {
            $builder->where('role', self::EMPLOYEE);
        });
    }

    public function surveys()
    {
        return $this->hasMany(SurveyEmployee::class, 'user_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id');
    }
}
