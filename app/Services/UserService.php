<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{


    public function count($users): string
    {

        return $users->count();
    }



}
