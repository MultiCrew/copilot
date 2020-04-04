<?php

namespace App\Models\Flights;

use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class MasterFlight extends Model
{
    /**
     * The user that created the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestee()
    {
        return $this->belongsTo('App\Models\Users\User', 'requestee_id');
    }

    /**
     * The user that accepted the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acceptee()
    {
        return $this->belongsTo('App\Models\Users\User', 'acceptee_id');
    }

    /**
     * Return the user that is a member of the flight but not the authed user
     *
     * @return \App\Models\User\User $user
     */
    public function otherUser()
    {
        if ($this->isRequestee(Auth::user()))
        {
            return $this->acceptee;

        } else if ($this->isAcceptee(Auth::user()))
        {
            return $this->requestee;
        }
    }

    /**
     * Check to see if user is the requestee
     *
     * @param \App\Models\User\User $user
     *
     * @return boolean
     */
    public function isRequestee(User $user)
    {
        return $this->requestee_id == $user->id;
    }

    /**
     * Check to see if user is the acceptee
     *
     * @param \App\Models\User\User $user
     *
     * @return boolean
     */
    public function isAcceptee(User $user)
    {
        return $this->acceptee_id == $user->id;
    }

    /**
     * Returns whether the given user is either requestee or acceptee
     *
     * @param \App\Models\User\User $user
     *
     * @return boolean
     */
    public function isInvolved(User $user)
    {
        return $this->isRequestee($user) || $this->isAcceptee($user);
    }
}
