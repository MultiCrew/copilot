<?php

namespace App\Models\Flights;

use Illuminate\Database\Eloquent\Model;

class ArchivedFlight extends Model
{
    use FlightTrait;

    /**
     * Attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'departure', 'arrival', 'aircraft', 'requestee_id', 'acceptee_id'
    ];
}
