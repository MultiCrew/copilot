<?php

namespace App\Models\Flights;

use Illuminate\Database\Eloquent\Model;
use \Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        return $this->belongsTo('App\Models\Flights\FlightRequest', 'id', 'plan_id');
    }

    /**
     * Accepts the flight plan as the logged in user
     */
    public function accept()
    {
        $flight = $this->flight;

        if (Auth::id() === $flight->requestee_id) {
            $this->requestee_accept = Auth::id();
        } else {
            $this->acceptee_accept = Auth::id();
        }

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

    /**
     * Generate a string to store a plan PDF
     *
     * @return string
     */
    public static function generateCode()
    {
        return Str::random(10);
    }

    /**
     * Function to archive a flight plan
     * TODO: Currently, any associated file is deleted, the plan dissociated with the flight and
     *       the plan model deleted. In future, some of this data may be saved
     *
     * @param  FlightPlan $plan The plan to archive
     */
    public static function archive(FlightPlan $plan)
    {
        Storage::delete($plan->file);

        $flight = $plan->flight;

        $flight->plan()->dissociate();
        $flight->save();

        $plan->delete();
    }
}
