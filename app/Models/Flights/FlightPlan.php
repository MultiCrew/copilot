<?php

namespace App\Models\Flights;

use Illuminate\Database\Eloquent\Model;
use \Auth;

class FlightPlan extends Model
{
    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'ofp_json'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ofp_json' => 'array',
    ];

    /**
     * The flight that belongs to the plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flight()
    {
        return $this->belongsTo('App\Models\Flights\Flight', 'id', 'plan_id');
    }

    /**
     * Accepts the flight plan as the logged in user
     */
    public function accept()
    {
        $flight = $this->flight;

        if (Auth::id() === $flight->requestee_id)
            $this->requestee_accept = Auth::id();
        else
            $this->acceptee_accept = Auth::id();

        $this->save();
    }

    /**
     * Rejects the flight plan as the logged in user
     */
    public function reject()
    {
        $flight = $this->flight;

        if (Auth::id() === $flight->requestee_id)
            $this->requestee_accept = Auth::id();
        else
            $this->acceptee_accept = Auth::id();

        $this->save();
    }

    /**
     * Checks whether the authed user has accepted the plan already
     *
     * @return booelan true if both the suer has accepted the plan, otherwise false
     */
    public function hasAccepted()
    {
        return ($this->requestee_accept === Auth::id() || $this->acceptee_accept === Auth::id());
    }

    /**
     * Checks whether the plan is approved or not (both pilots have reviewed accepted)
     *
     * @return booelan true if both pilots have accepted the plan, otherwise false
     */
    public function isApproved()
    {
        return ($this->requestee_accept && $this->acceptee_accept);
    }
}
