<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $casts = [
        'sims' => 'array',
        'weather' => 'array',
        'show_name' => 'boolean',
        'airac' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'show_name', 'location', 'sims', 'weather', 'airac', 'level', 'connection', 'procedures', 'user_id'
    ];

    /**
     * The user the profile belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }
}
