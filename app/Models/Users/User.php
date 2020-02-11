<?php

namespace App\Models\Users;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The flights the user has requested.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany('App\Models\Flights\Flight', 'requestee_id')->where('acceptee_id', null);
    }

    /**
     * The flights the user has accepted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accepts()
    {
        return $this->hasMany('App\Models\Flights\Flight', 'acceptee_id');
    }

    /**
     * The notifications the user has subscribed to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notificationSubscription()
    {
        return $this->belongsTo('App\Models\Users\UserNotifications', 'user_id');
    }
}
