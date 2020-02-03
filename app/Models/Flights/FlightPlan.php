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
     * Gets the flight associated with the plan
     *
     * @return     Flight   The flight which references this plan
     */
    public function getFlight()
    {
        return Flight::where('plan_id', $this->id)->firstOrFail();
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
            $this->accepttee_accept = 1;

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
            $this->accepttee_accept = 0;

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
