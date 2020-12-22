<?php

namespace App\Imports;

use App\Models\Airports\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class CountryImport implements ToModel, WithProgressBar, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!Country::where('code', $row['code'])->exists()) {
            return new Country([
                'code' => $row['code'],
                'name' => $row['name'],
                'continent' => $row['continent'],
            ]);
        }
    }
}
