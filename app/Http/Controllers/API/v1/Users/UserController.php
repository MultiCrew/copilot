<?php

namespace App\Http\Controllers\API\v1\Users;

use Exception;
use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\API\APIController as Controller;

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
            return $this->respondWithObject(new UserResource($user));
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound(array($e->getMessage()));
        }
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
     * Update the authenticated User
     *
     * TODO implement updating user profiles
     *
     * @bodyParam email string The updated email of the User. Example: user@example.com
     *
     * @responseFile responses/user.json
     * @responseFile scenario="when using the email scope" responses/user.email.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->user()->tokenCan('user.update')) {
            try {
                $user = $request->user();

                $request->validate([
                    'email' => 'email|max:255'
                ]);

                if ($request->email) {
                    $user->email = $request->email;
                }

                $user->save();

                return $this->respondWithObject(new UserResource($user));
            } catch (Exception $e) {
                return $this->errorInternalError(array($e->getMessage()));
            }
        } else {
            return $this->errorUnauthorized(['INVALID_SCOPE']);
        }
    }
}
