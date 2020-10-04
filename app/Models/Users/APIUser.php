<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class APIUser extends Authenticatable
{
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'url', 'usage'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'api_users';

    /**
     * The user who created the API User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'id', 'user_id');
    }
}
