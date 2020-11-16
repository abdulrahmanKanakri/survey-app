<?php

namespace App\Models\User;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Builder;

class Standard extends User
{
    protected $attributes = ['role' => self::STANDARD];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('standard', function (Builder $builder) {
            $builder->where('role', self::STANDARD);
        });
    }
    
    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_user', 'user_id', 'survey_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
}
