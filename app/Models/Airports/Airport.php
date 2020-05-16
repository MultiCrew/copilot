<?php

namespace App\Models\Airports;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icao', 'name', 'latitude', 'longitude', 'elevation'
    ];
}
