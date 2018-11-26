<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public static function findByName($role_name) {
        return UserRole::where('name', $role_name)->first();
    }
}
