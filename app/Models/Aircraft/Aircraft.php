<?php

namespace App\Models\Aircraft;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icao', 'iata', 'name',
    ];
}
