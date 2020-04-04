<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    /**
     * The user the settings belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'id');
    }

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
