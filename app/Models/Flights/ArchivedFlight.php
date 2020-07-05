<?php

namespace App\Models\Flights;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FlightTrait;

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

    /**
     * The ApprovedAircraft type this flight request is for
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aircraft()
    {
        return $this->belongsTo('App\Models\Aircraft\ApprovedAircraft');
    }
}
