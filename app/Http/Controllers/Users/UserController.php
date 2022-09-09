<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ActivityLogs\ActivityLogHelper;
use App\Helpers\Gru;
use App\Helpers\Minion;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Http\Resources\UserCollection;
use App\Models\User\User;
use App\Models\User\UserPublication;
use App\Services\Users\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count=$this->userService->count(User::all());
      return  ['users'=>UserCollection::collection(User::paginate(10)),'count'=>$count];

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

    public function store( UserPostRequest $request )
    {
        $validated = $request->validated();

        if (!$validated) {
            return 'error';
        }


        $user=$this->userService->addUser($request);

        return $user ;
    }


        /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        return new UserCollection(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserPostRequest  $request
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserPostRequest $request, User $user)
    {
        $validated = $request->validated();
        if (!$validated) {
            return 'error';
        }

        $user=$this->userService->updateUser($request,$user);

        return $user;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }


}
