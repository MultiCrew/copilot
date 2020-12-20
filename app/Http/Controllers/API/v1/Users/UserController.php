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
     * Get the authenticated User
     *
     * @responseFile responses/user.json
     * @responseFile scenario="when using the email scope" responses/user.email.json
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = User::find(auth()->id());
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound(array($e->getMessage()));
        }

        return $this->respondWithObject(new UserResource($user));
    }

    /**
     * Get a specified User
     *
     * @urlParam user integer required The ID of the user
     *
     * @responseFile responses/user.json
     * @responseFile scenario="when using the email scope" responses/user.email.json
     *
     * @param  \App\Models\Users\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try {
            return $this->respondWithObject(new UserResource($user));
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound(array($e->getMessage()));
        }
    }

    /**
     * Update the specified User
     *
     * TODO implement user updating along with add comments
     *
     * @urlParam user integer required The ID of the user
     *
     * @responseFile responses/user.json
     * @responseFile scenario="when using the email scope" responses/user.email.json
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
