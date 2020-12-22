<?php

namespace App\Models\Airports;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'continent',
    ];

    public function getContinentAttribute($value)
    {
        switch ($value) {
            case 'AF':
                return 'Africa';
                break;
            case 'AN':
                return 'Antartica';
                break;
            case 'AS':
                return 'Asia';
                break;
            case 'EU':
                return 'Europe';
                break;
            case 'NA':
                return 'North America';
                break;
            case 'OC':
                return 'Oceania';
                break;
            case 'SA':
                return 'South America';
                break;
            default:
                return null;
                break;
        }
    }
}
