<?php

namespace App\Models\Roles;

use App\Models\Traits\CanMonita;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
}    use CanMonita;

