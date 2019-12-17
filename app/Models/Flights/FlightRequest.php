<?php

namespace App\Models\Flights;

use Illuminate\Database\Eloquent\Model;

class FlightRequest extends Model
{
    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'departure', 'arrival', 'aircraft'
    ];
    /**
     * The user that created the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestee()
    {
        return $this->belongsTo('App\Models\Users\User', 'user_id');
    }

    /**
     * Get whether a user is the organiser of a flight.
     *
     * @param \Concuflight\Models\User\User $user
     *
     * @return boolean
     */
    public function isOrganiser(User $user)
    {
        return $this->user_id == $user->id;
    }
}
