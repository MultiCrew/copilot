<?php

namespace App\Models\Flights;

class ArchivedFlight extends MasterFlight
{
    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'departure', 'arrival', 'aircraft', 'requestee_id', 'acceptee_id'
    ];
}
