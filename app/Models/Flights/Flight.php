<?php

namespace App\Models\Flights;

use Illuminate\Support\Str;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;

class Flight extends MasterFlight
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
     * The requestee on this flight
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestee()
    {
        return $this->belongsTo('App\Models\Users\User', 'requestee_id');
    }

    /**
     * The acceptee on this flight
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
     * The plan that belongs to the flight.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo('App\Models\Flights\FlightPlan', 'plan_id');
    }

    /**
     * Checks if a plan exists for the flight
     *
     * @return boolean
     */
    public function isPlanned()
    {
        return !empty($this->plan_id);
    }

    /**
     * Checks if a plan is accepted by both users
     *
     * @return boolean
     */
    public function planAccepted()
    {
        if ($this->isPlanned()) {
            if ($this->plan->requestee_accept && $this->plan->acceptee_accept) {
                return true;
            }
        }

        return false;
    }

    /**
     * Scope a query to only include public flights.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->where('public', 1)->get();
    }

    /**
     * Scope a query to only include open requests.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpenRequest($query)
    {
        return $query->where('requestee_id', Auth::id())->whereNull('acceptee_id')->get();
    }

    /**
     * Scope a query to only include accepted requests.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAcceptedRequest($query)
    {
        return $query->where('requestee_id', Auth::id())->whereNotNull('acceptee_id')->get();
    }

    /**
     * Scope a query to only include unplanned flights.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnplannedFlight($query)
    {
        return $query->whereNull('plan_id')->whereNotNull('acceptee_id')->where(function ($q) {
            $q->where('requestee_id', Auth::id())->orWhere('acceptee_id', Auth::id());
        })->get();
    }

    /**
     * Scope a query to only include unplanned flights.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePlannedFlight($query)
    {
        return $query->whereNotNull('plan_id')->where(function ($q) {
            $q->where('requestee_id', Auth::id())->orWhere('acceptee_id', Auth::id());
        })->get();
    }

    /**
     * Scope a query to only include users plans.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserPlans($query)
    {
        return $query->whereNotNull('plan_id')->where(function ($q) {
            $q->where('requestee_id', Auth::id())->orWhere('acceptee_id', Auth::id());
        })->get()->pluck('plan')->flatten();
    }
}
