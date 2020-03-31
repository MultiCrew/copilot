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
    public function userNotifications()
    {
        return $this->belongsTo('App\Models\Users\UserNotification', 'user_id');
    }

    /**
     * Required for the WebDevEtc\BlogEtc package.
     * Enter your own logic (e.g. if ($this->id === 1) to
     *   enable this user to be able to add/edit blog posts
     *
     * @return bool - true = they can edit / manage blog posts,
     *        false = they have no access to the blog admin panel
     */
    public function canManageBlogEtcPosts()
    {
        if (\App::environment('local')) {
            return $this->hasRole('admin');
        } else {
            return false;
        }
    }
}
