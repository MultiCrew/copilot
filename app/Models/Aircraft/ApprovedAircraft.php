<?php

namespace App\Models\Aircraft;

use Illuminate\Database\Eloquent\Model;

class ApprovedAircraft extends Model
{
    protected $fillable = [
        'icao', 'name', 'sim', 'approved'
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];
}
