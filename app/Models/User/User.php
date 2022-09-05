<?php

namespace App\Models\User;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


/**
 * App\Models\User\User
 *
* @property string $guard_name
 *
 *
 */

class User extends Authenticatable
{
    use HasFactory,HasRoles,HasApiTokens;
    protected $fillable = ['name', 'email', 'password','slug'];

    protected $table = 'users';
}
