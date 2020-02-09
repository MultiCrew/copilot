<?php

namespace App\Models\Flights;

use Illuminate\Database\Eloquent\Model;

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
        $flight = $this->getFlight();

        if (Auth::id() === $flight->requestee)
            $this->requestee_accept = 1;
        else
            $this->acceptee_accept = 1;

        $this->save();
    }

    /**
     * Rejects the flight plan as the logged in user
     */
    public function reject()
    {
        $flight = $this->getFlight();

        if (Auth::id() === $flight->requestee)
            $this->requestee_accept = 0;
        else
            $this->acceptee_accept = 0;

        $this->save();
    }

    /**
     * Checks whether the plan is approved or not (both pilots have reviewed accepted)
     *
     * @return boolean true if both pilots have accepted the plan, otherwise false
     */
    public function isApproved()
    {
        return ($this->requestee_accept && $this->acceptee_accept);
    }
}
