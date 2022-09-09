<?php

namespace App\Services\Users;

use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    public function count($users){
        return $users->count();
    }

    public function addUser($request){
        $selectedRoles = Role::find($request->get('role'))->name;

        $user = User::create(
            [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'slug'=>'',
            ]
        );
        $user->syncRoles($selectedRoles);

        $user->save();

        return $user;
    }

    public function updateUser($request,$user){

        $selectedRoles = Role::find($request->get('role'))->name;
        $user->update( $request->only( [ 'name', 'email' ] ) );

        if ( $request->has( 'password' ) ) {
            $user->password = $request->get( 'password' );
        }
        $user->save();
        $user->syncRoles( $selectedRoles );

        return $user;
    }




}
