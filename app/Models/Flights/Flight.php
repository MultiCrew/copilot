<?php

namespace App\Models\Flights;

use Illuminate\Support\Str;
use App\Models\Users\User as User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'departure', 'arrival', 'aircraft', 'requestee_id', 'acceptee_id', 'plan_id', 'public'
    ];

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
     * Generate a public ID for a flight.
     *
     * @return string
     */
    public static function generatePublicId()
    {
        return Str::random(10);
    }

    /**
     * Check to see if flight is public.
     *
     * @param Flight $flight
     * @return boolean
     */
    public static function isPublic(Flight $flight)
    {
        return $flight->public == 1 ? true : false;
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
     * Scope a query to only include public flights.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->where('public', 1);
    }

    /**
     * Scope a query to only include open requests.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpenRequest($query)
    {
        return $query->where('requestee_id', Auth::id())->whereNull('acceptee_id');
    }

    /**
     * Scope a query to only include accepted requests.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAcceptedRequest($query)
    {
        return $query->where('requestee_id', Auth::id())->whereNotNull('acceptee_id');
    }

    /**
     * Scope a query to only include unplanned requests.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnplannedRequest($query)
    {
        return $query->where('requestee_id', Auth::id())->whereNotNull('acceptee_id')->whereNull('plan_id');
    }
}
