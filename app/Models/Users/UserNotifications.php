<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserNotifications extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'airport_request' => 'array',
        'aircraft_request' => 'array',
    ];
}
