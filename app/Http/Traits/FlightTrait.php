<?php

namespace App\Http\Traits;

use Exception;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;

trait FlightTrait {
    /**
     * The user that created the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestee()
    {
        return $this->belongsTo('App\Models\Users\User', 'requestee_id', 'id');
    }

    /**
     * The user that accepted the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acceptee()
    {
        return $this->belongsTo('App\Models\Users\User', 'acceptee_id', 'id');
    }

    /**
     * Return the user that is a member of the flight but not the authed user
     *
     * @return User
     * @throws Exception
     */
    public function otherUser()
    {
        if (Auth::id() === $this->requestee_id) {
            return User::find($this->acceptee_id);
        } elseif (Auth::id() === $this->acceptee_id) {
            return User::find($this->requestee_id);
        } else {
            throw new Exception("There is no other user");
        }
    }

    /**
     * Check to see if user is the requestee
     *
     * @param User $user
     *
     * @return bool
     */
    public function isRequestee(User $user)
    {
        return $this->requestee_id == $user->id;
    }

    /**
     * Check to see if user is the acceptee
     *
     * @param User $user
     *
     * @return bool
     */
    public function isAcceptee(User $user)
    {
        return $this->acceptee_id == $user->id;
    }

    /**
     * Check to see if the user in involved in the flight
     *
     * @param  User $user
     * @return bool
     */
    public function isInvolved(User $user)
    {
        return $this->isRequestee($user) || $this->isAcceptee($user);
    }
}
