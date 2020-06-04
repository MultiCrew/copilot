<?php

namespace App\Models\Flights;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\FlightTrait;

/**
 * Class FlightRequest
 *
 * @mixin \Eloquent
 */
class FlightRequest extends Model
{
    use FlightTrait;

    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'departure', 'arrival', 'aircraft', 'requestee_id', 'acceptee_id', 'public'
    ];

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
    public function isAccepted()
    {
        return !empty($this->acceptee_id);
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
     * Generate a public ID for a flight.
     *
     * @return string
     */
    public static function generateCode()
    {
        return Str::random(10);
    }

    /**
     * Scope a query to only include public flights.
     *
     * @return Builder[]|Collection
     */
    public function scopePublic(Builder $query)
    {
        return $query->where('public', 1)->get();
    }

    /**
     * Scope a query to only include open requests.
     *
     * @return Builder[]|Collection
     */
    public function scopeOpenRequest(Builder $query)
    {
        return $query->where('requestee_id', Auth::id())->whereNull('acceptee_id')->get();
    }

    /**
     * Scope a query to only include accepted requests.
     *
     * @return Builder[]|Collection
     */
    public function scopeAcceptedRequest(Builder $query)
    {
        return $query->where('requestee_id', Auth::id())->whereNotNull('acceptee_id')->get();
    }

    /**
     * Scope a query to only include unplanned flights.
     *
     * @return Builder[]|Collection
     */
    public function scopeUnplannedFlight(Builder $query)
    {
        return $query->whereNull('plan_id')->whereNotNull('acceptee_id')->where(function ($q) {
            $q->where('requestee_id', Auth::id())->orWhere('acceptee_id', Auth::id());
        })->get();
    }

    /**
     * Scope a query to only include unplanned flights.
     *
     * @return Builder[]|Collection
     */
    public function scopePlannedFlight(Builder $query)
    {
        return $query->whereNotNull('plan_id')->where(function (Builder $q) {
            $q->where('requestee_id', Auth::id())->orWhere('acceptee_id', Auth::id());
        })->get();
    }

    /**
     * Scope a query to only include users plans.
     *
     * @return Builder[]|Collection
     */
    public function scopeUserPlans(Builder $query)
    {
        return $query->whereNotNull('plan_id')->where(function (Builder $q) {
            $q->where('requestee_id', Auth::id())->orWhere('acceptee_id', Auth::id());
        })->get()->pluck('plan')->flatten();
    }
}
