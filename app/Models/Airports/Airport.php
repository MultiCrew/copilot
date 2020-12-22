<?php

namespace App\Models\Airports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Airport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icao', 'name', 'latitude', 'longitude', 'elevation', 'iso_country'
    ];

    /**
     * Return the Country the Airport is in
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo('App\Models\Airports\Country', 'iso_country', 'code');
    }
}
