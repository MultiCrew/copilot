<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use App\Models\Airports\Airport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class AirportImport implements ToModel, WithProgressBar, WithStartRow, WithBatchInserts, WithHeadingRow
{

    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['type'] == 'heliport' || $row['type'] == 'closed_airport') return null;

        if(!Airport::where('icao', $row['ident'])->exists()) {
            return new Airport([
                'icao' => $row['ident'],
                'name' => $row['name'],
                'latitude' => $row['latitude_deg'],
                'longitude' => $row['longitude_deg'],
                'elevation' => $row['elevation_ft'],
                'iso_country' => $row['iso_country']
            ]);
        }
    }

    public function batchSize(): int
    {
        return 5000;
    }

    public function startRow(): int
    {
        return 2;
    }
}
