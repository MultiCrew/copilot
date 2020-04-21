<?php

namespace App\Http\Traits;

use Exception;
use Illuminate\Support\Facades\Auth;

trait Flight{
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
}