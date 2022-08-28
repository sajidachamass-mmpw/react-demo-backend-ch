<?php

namespace App\Http\Controllers\User;

use App\Helpers\ActivityLogs\ActivityLogHelper;
use App\Helpers\Gru;
use App\Helpers\Minion;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\UserPublication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User\Role;
use App\Http\Resources\UserCollection;
use App\Http\Requests\UserPostRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return  UserCollection::collection(User::all());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function save(UserPostRequest  $request){

        $validated = $request->validated();


        if (!$validated) {
            return 'error';
        }
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

       return $user ;
    }
    public function store( Request $request )
    {

    }


        /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return new UserCollection(User::findOrFail($request->get('id')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }
    public function updateUser(UserPostRequest $request)
    {

        $user  = User::find($request->get('id'));

        $validated = $request->validated();
        if (!$validated) {
            return 'error';
        }

        $selectedRoles = Role::find($request->get('role'))->name;
        $user->update( $request->only( [ 'name', 'email' ] ) );

        if ( $request->has( 'password' ) ) {
            $user->password = $request->get( 'password' );
        }
        $user->save();
        $user->syncRoles( $selectedRoles );

       return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::FindorFail($id);
        $user->delete();
    }
}