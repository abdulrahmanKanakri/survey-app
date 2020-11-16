<?php

namespace App\Models;

use App\Models\User\Employee;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'group_user', 'group_id', 'user_id');
    }
}
