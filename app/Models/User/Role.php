<?php

namespace App\Models\User;

use App\Models\Traits\CanMonita;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use CanMonita;
}
