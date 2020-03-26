<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'request_accepted' => 'boolean',
        'plan_accepted' => 'boolean',
        'plan_rejected' => 'boolean',
    ];
}
