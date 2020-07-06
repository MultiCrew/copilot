<?php

namespace App\Models\Aircraft;

use Illuminate\Database\Eloquent\Model;

class ApprovedAircraft extends Model
{
    protected $fillable = [
        'icao', 'name', 'sim', 'added_by', 'approved'
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    /**
     * The flights requests that are for this aircraft
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function flights()
    {
        return $this->hasMany('App\Models\Flights\FlightRequest', 'aircraft_id');
    }
}
