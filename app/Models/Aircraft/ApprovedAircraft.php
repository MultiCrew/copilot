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
}
