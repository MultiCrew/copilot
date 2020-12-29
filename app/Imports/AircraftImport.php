<?php

namespace App\Imports;

use App\Models\Aircraft\Aircraft;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class AircraftImport implements ToModel, WithProgressBar
{

    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[2] == '\N') return null;

        if(!Aircraft::where('icao', $row[2])->exists()) {
            return new Aircraft([
                'icao' => $row[2],
                'iata' => $row[1],
                'name' => $row[0],
            ]);
        }
    }
}
