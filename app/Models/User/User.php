<?php

namespace App\Models\User;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User\User
 *
* @property string $guard_name
 *
 *
 */

class User extends Model
{
    use HasFactory,HasRoles;
    protected $fillable = ['name', 'email', 'password','slug'];

    protected $table = 'users';
}
