<?php

namespace App\Models\Flights;

use App\Models\Users\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
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
            return $this->acceptee;
        } elseif (Auth::id() === $this->acceptee_id) {
            return $this->requestee;
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
     * Returns whether the given user is either requestee or acceptee
     *
     * @param User $user
     *
     * @return bool
     */
    public function isInvolved(User $user)
    {
        return $this->isRequestee($user) || $this->isAcceptee($user);
    }

    /**
     * Returns whether the flight has been accepted
     */
    public function isAccepted()
    {
        return !is_null($this->acceptee_id);
    }

    /**
     * Check to see if flight is public
     *
     * @return bool
     */
    public function isPublic()
    {
        return $this->public == 1 ? true : false;
    }
}
