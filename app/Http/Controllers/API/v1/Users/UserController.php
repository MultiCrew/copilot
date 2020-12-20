<?php

namespace App\Http\Controllers\API\v1\Users;

use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\API\APIController as Controller;
use App\Http\Resources\UserResource;

/**
 * @group User
 */
class UserController extends Controller
{
    /**
     * Get the Authenticated User
     *
     * @responseFile
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = User::find(auth()->id());
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound(array($e->getMessage()));
        }

        return new UserResource($user);
    }

    /**
     * Get the specified User
     *
     * @param  \App\Models\Users\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified User
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Users\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }
}
