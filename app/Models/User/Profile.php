<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Standard::class, 'user_id');
    }
}
