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
        'new_request' => 'array'
	];
	
	/**
     * The user the notification settings belong to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'user_id');
    }
}
