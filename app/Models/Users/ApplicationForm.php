<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'software_dev', 'flight_sim', 'online', 'status',
    ];

    /**
     * The user who submitted the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasOne('App\Models\Users\User');
    }
}
