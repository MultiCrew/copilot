<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip',
        'user_agent'
    ];
}
