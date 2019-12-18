<?php

namespace App\Models\Flights;

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
    public function isPublic(Flight $flight)
    {
        return $flight->public;
    }


}
